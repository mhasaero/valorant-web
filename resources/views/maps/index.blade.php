<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Informasi Map Valorant') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <!-- Header Banner -->
                <div class="flex flex-col space-y-6 items-center justify-between bg-gradient-to-r from-gray-900 to-gray-800 px-4 sm:px-6 py-6 border-b border-gray-200">
                    <div class=" py-4 px-5 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 w-full lg:w-auto mb-4 lg:mb-0">
                        <h3 class="text-xl font-bold text-black">Eksplorasi Map Valorant</h3>
                        <p class="text-gray-100 text-sm mt-1">Pelajari layout dan strategi untuk setiap map</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="search" placeholder="Cari map..." class="pl-10 pr-4 py-2 rounded-lg border focus:ring-2 focus:ring-red-500 focus:border-red-500 w-full text-sm placeholder-gray-400">
                        </div>
                    </div>
                </div>
                
                <!-- Maps Grid Container -->
                <div id="mapsContainer" class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 p-4 sm:p-6 md:p-8 bg-gray-50">
                    @foreach ($maps as $map)
                        <div 
                            class="map-card bg-white border border-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:border-red-300 flex flex-col h-full"
                            data-name="{{ strtolower($map['displayName']) }}"
                        >
                            <div class="relative">
                                <div class="absolute top-0 right-0 bg-gray-800 text-xs text-white px-2 py-1 rounded-bl-lg font-medium opacity-90 z-10">
                                    {{ $map['coordinates'] ?? 'Unknown' }}
                                </div>
                                <div class="h-40 sm:h-48 overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
                                    <img src="{{ $map['splash'] ?? $map['displayIcon'] ?? '/images/map-placeholder.jpg' }}" alt="{{ $map['displayName'] }}" 
                                         class="h-full w-full object-cover transform transition-transform duration-500 hover:scale-110">
                                </div>
                            </div>
                            
                            <div class="p-4 flex flex-col flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-bold text-gray-800 truncate">{{ $map['displayName'] }}</h4>
                                    <div class="flex space-x-1">
                                        <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
                                        <span class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                                        <span class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">
                                    {{ Str::limit($map['narrativeDescription'] ?? 'No description available', 100) }}
                                </p>
                                
                                <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
                                    <div class="flex space-x-1">
                                        @if(isset($map['sites']))
                                            @foreach(explode(',', $map['sites']) as $site)
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">{{ trim($site) }}</span>
                                            @endforeach
                                        @else
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">A</span>
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">B</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('maps.show', $map['uuid']) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- No Results State -->
                <div id="noResults" class="hidden py-10 text-center bg-gray-50">
                    <div class="bg-white max-w-md mx-auto p-6 rounded-xl shadow-md">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada map ditemukan</h3>
                        <p class="mt-2 text-sm text-gray-500">Coba pencarian lain atau reset filter.</p>
                        <div class="mt-4">
                            <button type="button" id="resetFilters" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="{{ asset('js/maps/index.js') }}"></script>
</x-app-layout>