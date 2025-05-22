<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MapController extends Controller
{
    public function index(): View
    {
        $response = Http::get('https://valorant-api.com/v1/maps');

        if ($response->successful()) {
            $mapsData = $response->json()['data'];
            
            // Filter out non-standard maps like The Range
            $filteredMaps = array_filter($mapsData, function($map) {
                return !in_array($map['displayName'], ['The Range', 'Shooting Range']);
            });
            
            return view('maps.index', ['maps' => array_values($filteredMaps)]);
        } else {
            // Handle error jika permintaan gagal
            return view('maps.index', ['maps' => []]); // Atau tampilkan pesan error
        }
    }

    public function show($uuid)
    {
        // Ambil data map dari API Valorant
        $response = Http::get("https://valorant-api.com/v1/maps/{$uuid}");

        // Jika gagal ambil data
        if (!$response->successful()) {
            abort(404, 'Map tidak ditemukan.');
        }

        $map = $response->json('data');

        // Kirim ke view
        return view('maps.show', compact('map'));
    }
}