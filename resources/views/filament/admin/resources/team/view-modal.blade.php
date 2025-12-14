<div class="space-y-6">
    {{-- Team Header with Logo --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6">
        @if($record->logo)
            <div class="mb-4">
                <img src="{{ Storage::url($record->logo) }}" alt="{{ $record->name }}" class="w-full max-w-md mx-auto h-48 object-contain rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 shadow-lg p-4">
            </div>
        @endif
        
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $record->name }}</h2>
            <div class="flex items-center gap-3 flex-wrap">
                @if($record->region)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $record->region }}
                    </span>
                @endif
                
                @if($record->city)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                        {{ $record->city }}
                    </span>
                @endif
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        @if($record->is_active)
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        @else
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        @endif
                    </svg>
                    {{ $record->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            
            @if($record->description)
                <p class="mt-3 text-gray-700 dark:text-gray-300 text-sm">{{ $record->description }}</p>
            @endif
        </div>
    </div>

    {{-- Players Statistics --}}
    @php
        $totalPlayers = $record->players()->count();
        $activePlayers = $record->players()->where('is_active', true)->count();
        $inactivePlayers = $totalPlayers - $activePlayers;
        $meetsMinimum = $activePlayers >= 5;
    @endphp
    
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Total Players</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">{{ $totalPlayers }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Active Players</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">{{ $activePlayers }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Inactive Players</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $inactivePlayers }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Minimum Players Alert --}}
    @if(!$meetsMinimum)
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Minimum Player Tidak Terpenuhi</h4>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                        Tim ini membutuhkan minimal <strong>5 player aktif</strong> untuk dapat digunakan dalam pertandingan. 
                        Saat ini hanya ada <strong>{{ $activePlayers }} player aktif</strong>. 
                        Tambahkan {{ 5 - $activePlayers }} player aktif lagi atau aktifkan player yang ada.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-green-800 dark:text-green-200">Tim Siap Bertanding</h4>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                        Tim ini sudah memenuhi persyaratan minimal player aktif dan siap digunakan untuk pertandingan.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Active Players List --}}
    @if($activePlayers > 0)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                Active Players ({{ $activePlayers }})
            </h3>
            <div class="space-y-2">
                @foreach($record->players()->where('is_active', true)->get() as $index => $player)
                    <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $player->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $player->position ?? 'Position not set' }} 
                                    @if($player->jersey_number)
                                        • #{{ $player->jersey_number }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Active
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Inactive Players List --}}
    @if($inactivePlayers > 0)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                </svg>
                Inactive Players ({{ $inactivePlayers }})
            </h3>
            <div class="space-y-2">
                @foreach($record->players()->where('is_active', false)->get() as $index => $player)
                    <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700 opacity-60">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 font-semibold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $player->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $player->position ?? 'Position not set' }}
                                    @if($player->jersey_number)
                                        • #{{ $player->jersey_number }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            Inactive
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- No Players Warning --}}
    @if($totalPlayers === 0)
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Belum Ada Player</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        Tim ini belum memiliki player. Tambahkan minimal 5 player aktif untuk menggunakan tim ini dalam pertandingan.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Timestamps --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Dibuat pada</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Terakhir diupdate</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>