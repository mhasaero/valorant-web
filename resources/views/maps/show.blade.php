<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ $map['displayName'] }} - {{ __('Detail Map') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('maps.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Map
                </a>
            </div>

            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <!-- Hero Map Section -->
                <div class="relative h-64 sm:h-80 md:h-96 bg-gray-900 rounded-t-xl overflow-hidden">
                    <img 
                        src="{{ $map['splash'] ?? $map['displayIcon'] ?? '/images/map-placeholder.jpg' }}" 
                        alt="{{ $map['displayName'] }}" 
                        class="w-full h-full object-cover opacity-90"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-4 sm:p-6">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white">{{ $map['displayName'] }}</h1>
                        @if($map['coordinates'] ?? false)
                            <div class="inline-flex items-center mt-2 px-3 py-1 bg-gray-800 bg-opacity-70 rounded-full">
                                <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-white text-sm">{{ $map['coordinates'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map Info Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px overflow-x-auto">
                        <button id="tab-overview" class="tab-btn border-red-500 text-red-600 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                            Overview
                        </button>
                        <button id="tab-callouts" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                            Callouts
                        </button>
                        <button id="tab-layout" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                            Layout
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-4 sm:p-6">
                    <!-- Overview Tab -->
                    <div id="content-overview" class="tab-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="md:col-span-1 lg:col-span-2 min-w-0">
                                <!-- Description -->
                                <div class="mb-6">
                                    <h2 class="text-xl font-bold text-gray-800 mb-3">Description</h2>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700">
                                            {{ $map['narrativeDescription'] ?? 'No description available for this map.' }}
                                        </p>
                                    </div>
                                </div>
                                @if($map['tacticalDescription'] ?? false)
                                <div class="mb-6">
                                    <h2 class="text-xl font-bold text-gray-800 mb-3">Tactical Overview</h2>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700">{{ $map['tacticalDescription'] }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4">Map Info</h3>
                                    <div class="space-y-4">
                                        <!-- Sites -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Bomb Sites</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @if(isset($map['sites']))
                                                    @foreach(explode(',', $map['sites']) as $site)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Site {{ trim($site) }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Site A
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Site B
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Coordinates -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Coordinates</h4>
                                            <p class="text-gray-900 font-medium">{{ $map['coordinates'] ?? 'Unknown' }}</p>
                                        </div>
                                        <!-- Size -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Map Size</h4>
                                            <p class="text-gray-900 font-medium">{{ $map['size'] ?? 'Standard' }}</p>
                                        </div>
                                        <!-- Added Date -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Added to Game</h4>
                                            <p class="text-gray-900 font-medium">{{ isset($map['date']) ? \Carbon\Carbon::parse($map['date'])->format('d M Y') : 'Original Map' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Callouts Tab -->
                    <div id="content-callouts" class="tab-content hidden">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Map Callouts</h2>
                        @if(isset($map['callouts']) && count($map['callouts']) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($map['callouts'] as $callout)
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 hover:border-red-300 hover:shadow-md transition-all duration-200 min-w-0">
                                        <h3 class="font-medium text-gray-900 truncate">{{ $callout['regionName'] ?? 'Unnamed' }}</h3>
                                        <p class="text-gray-600 text-sm truncate">{{ $callout['superRegionName'] ?? 'Region' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Data callout untuk map ini tidak tersedia.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Layout Tab -->
                    <div id="content-layout" class="tab-content hidden">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Map Layout</h2>
                        <div class="flex justify-center bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-100">
                            @if($map['displayIcon'] ?? false)
                                <img 
                                    src="{{ $map['displayIcon'] }}" 
                                    alt="{{ $map['displayName'] }} layout" 
                                    class="max-w-full h-auto max-h-96"
                                >
                            @else
                                <div class="flex flex-col items-center justify-center text-center py-12">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500">Map layout tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/maps/show.js') }}"></script>
</x-app-layout>