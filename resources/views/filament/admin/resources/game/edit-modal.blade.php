<div class="space-y-6">
    {{-- Header Match Info --}}
    <div class="bg-gradient-to-r from-orange-600 to-orange-800 dark:from-orange-700 dark:to-orange-900 rounded-lg p-6 text-white">
        <div class="text-center mb-4">
            <div class="text-sm font-medium opacity-90">{{ $record->league }}</div>
            <div class="text-xs opacity-75 mt-1">
                {{ $record->date->format('d M Y') }} • {{ $record->time?->format('H:i') }} WIB
                @if($record->venue)
                    • {{ $record->venue }}
                @endif
            </div>
        </div>

        {{-- Teams Display --}}
        <div class="flex items-center justify-between gap-6">
            {{-- Team 1 --}}
            <div class="flex-1 text-center">
                <div class="mb-3">
                    @if($record->team1->logo)
                        <img src="{{ Storage::url($record->team1->logo) }}" 
                             alt="{{ $record->team1->name }}" 
                             class="w-16 h-16 mx-auto object-contain">
                    @else
                        <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold">{{ substr($record->team1->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <h3 class="text-lg font-bold">{{ $record->team1->name }}</h3>
            </div>

            <div class="text-2xl opacity-75">VS</div>

            {{-- Team 2 --}}
            <div class="flex-1 text-center">
                <div class="mb-3">
                    @if($record->team2->logo)
                        <img src="{{ Storage::url($record->team2->logo) }}" 
                             alt="{{ $record->team2->name }}" 
                             class="w-16 h-16 mx-auto object-contain">
                    @else
                        <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold">{{ substr($record->team2->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <h3 class="text-lg font-bold">{{ $record->team2->name }}</h3>
            </div>
        </div>
    </div>

    <div class="text-sm text-gray-500 dark:text-gray-400 text-center">
        ℹ️ Edit semua data match di bawah ini
    </div>
</div>