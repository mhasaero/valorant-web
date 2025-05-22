<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Informasi Agen Valorant') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <div class="flex items-center justify-between bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class=" py-6 px-6">
                        <h3 class="text-xl font-bold text-white">Pilih Agen Favoritmu</h3>
                        <p class="text-gray-100 text-sm mt-1">Pelajari kemampuan dan strategi masing-masing agen</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <input type="text" id="search" placeholder="Cari agen..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 w-full text-sm">
                        <select id="roleFilter" class="bg-white border border-gray-300 rounded-lg py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">All Role</option>
                            <option value="Duelist">Duelist</option>
                            <option value="Sentinel">Sentinel</option>
                            <option value="Controller">Controller</option>
                            <option value="Initiator">Initiator</option>
                        </select>
                    </div>
                </div>
                
                <div id="agentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 p-4">
                    @foreach ($agents as $agent)
                        <div class="agent-card bg-gray-50 border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:border-red-300 relative group" 
                             data-name="{{ strtolower($agent['displayName']) }}" 
                             data-role="{{ $agent['role']['displayName'] ?? '' }}">
                            <div class="absolute top-0 right-0 bg-gray-800 text-xs text-white px-2 py-1 rounded-bl-lg font-medium opacity-90">
                                {{ $agent['role']['displayName'] ?? 'Agen' }}
                            </div>
                            
                            <div class="h-32 bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center p-2 overflow-hidden">
                                <img src="{{ $agent['displayIcon'] }}" alt="{{ $agent['displayName'] }}" 
                                     class="h-full object-contain transform transition-transform duration-300 group-hover:scale-110">
                            </div>
                            
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-bold text-gray-800">{{ $agent['displayName'] }}</h4>
                                    <div class="flex space-x-1">
                                        <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $agent['color'] ?? '#ff4655' }}"></span>
                                        <span class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                                        <span class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 h-10">
                                    {{ $agent['description'] }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-1">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">Q</span>
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">E</span>
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">C</span>
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs text-gray-700 font-medium">X</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="noResults" class="hidden py-10 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada agen ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba pencarian lain atau reset filter.</p>
                    <div class="mt-3">
                        <button type="button" id="resetFilters" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Reset Filter
                        </button>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

    <script src="{{ asset('js/agents/index.js') }}"></script>
</x-app-layout>