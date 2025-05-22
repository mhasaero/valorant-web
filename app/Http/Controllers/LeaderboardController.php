<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    /**
     * Get the top leaderboard entries.
     *
     * @param int $limit
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        
        $leaderboard = Leaderboard::orderBy('score', 'desc')
            ->take($limit)
            ->get();
            
        return response()->json($leaderboard);
    }

    /**
     * Store a new leaderboard entry.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
        ]);

        $entry = new Leaderboard();
        $entry->name = $validated['name'];
        $entry->score = $validated['score'];
        
        // Associate with authenticated user if available
        if (Auth::check()) {
            $entry->user_id = Auth::id();
        }
        
        $entry->save();
        
        return response()->json($entry, 201);
    }

    /**
     * Delete all leaderboard entries.
     * Only administrators can perform this action.
     *
     * @return JsonResponse
     */
    public function deleteAll(): JsonResponse
    {
        // Check if user is admin - this is a simple example, you should implement proper authorization
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            Leaderboard::truncate();
            return response()->json(['message' => 'Leaderboard has been reset'], 200);
        }
        
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}