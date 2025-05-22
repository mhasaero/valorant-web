<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aim Training') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Aim Training</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <div class="canvas-container">
                                <canvas id="target-canvas" width="800" height="600" class="bg-gray-200 rounded-md"></canvas>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-4">
                                <p class="font-medium">Skor: <span id="score">0</span></p>
                                <p class="font-medium">Waktu: <span id="timer">30</span> detik</p>
                                <button id="start-button" class="bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Mulai</button>
                                
                                <div class="flex items-center">
                                    <label for="sensitivity" class="mr-2 font-medium">Sensitivitas:</label>
                                    <input 
                                        type="range" 
                                        id="sensitivity" 
                                        min="0.1" 
                                        max="2" 
                                        step="0.1" 
                                        value="1" 
                                        class="w-36"
                                    >
                                    <span id="sensitivity-value" class="ml-2">1.0</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <label for="target-size" class="mr-2 font-medium">Ukuran Target:</label>
                                    <input 
                                        type="range" 
                                        id="target-size" 
                                        min="5" 
                                        max="30" 
                                        step="1" 
                                        value="15" 
                                        class="w-36"
                                    >
                                    <span id="target-size-value" class="ml-2">15</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="text-lg font-semibold mb-3 flex justify-between items-center">
                                <span>Leaderboard</span>
                                @can('manage-leaderboard')
                                <button id="reset-leaderboard" class="text-xs bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                    Reset
                                </button>
                                @endcan
                            </h4>
                            <div class="mb-3">
                                <label for="player-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemain:</label>
                                <input 
                                    type="text" 
                                    id="player-name" 
                                    class="w-full p-2 border border-gray-300 rounded" 
                                    placeholder="Masukkan nama Anda"
                                    @auth
                                    value="{{ auth()->user()->name }}"
                                    @endauth
                                >
                            </div>
                            <div class="overflow-y-auto max-h-80">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Peringkat
                                            </th>
                                            <th class="py-2 px-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Nama
                                            </th>
                                            <th class="py-2 px-3 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Skor
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="leaderboard-body">
                                        <!-- Data leaderboard akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @csrf <!-- CSRF token for AJAX requests -->

    <!-- Include external JS and CSS files -->
    <link rel="stylesheet" href="{{ asset('css/aim_training.css') }}">
    <script src="{{ asset('js/aim_training.js') }}"></script>
</x-app-layout>