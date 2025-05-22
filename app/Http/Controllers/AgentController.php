<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $response = Http::get('https://valorant-api.com/v1/agents?isPlayableCharacter=true');

        if ($response->successful()) {
            $agentsData = $response->json()['data'];
            return view('agents.index', ['agents' => $agentsData]);
        } else {
            // Handle error jika permintaan gagal
            return view('agents.index', ['agents' => []]); // Atau tampilkan pesan error
        }
    }
}