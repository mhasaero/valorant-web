<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-black mb-4">Selamat datang di dashboard!</h3>
                    <p class="text-black mb-4">Anda dapat mengakses informasi Valorant melalui tautan di bawah ini:</p>
                    
                    <div class="mt-6 space-y-6">
                        <a href="{{ route('agents.index') }}" class="block p-6 text-black rounded-lg shadow-lg hover:bg-gray-800 ">
                            <h4 class="text-xl font-bold mb-2">Informasi Agen</h4>
                            <p>Lihat detail tentang semua agen Valorant</p>
                        </a>
                        
                        <a href="{{ route('maps.index') }}" class="block p-6 text-black rounded-lg shadow-lg hover:bg-gray-800 ">
                            <h4 class="text-xl font-bold mb-2">Informasi Peta</h4>
                            <p>Jelajahi berbagai peta dalam game Valorant</p>
                        </a>
                        
                        <a href="{{ route('aim.training') }}" class="block p-6 text-black rounded-lg shadow-lg hover:bg-gray-800 ">
                            <h4 class="text-xl font-bold mb-2">Aim Training</h4>
                            <p>Latih kemampuan membidik Anda</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>