<div class="space-y-6">
    {{-- Thumbnail Preview --}}
    @if($record->thumbnail)
        <div class="relative rounded-lg overflow-hidden bg-gray-900">
            <img 
                src="{{ Storage::url($record->thumbnail) }}" 
                alt="{{ $record->title }}"
                class="w-full h-auto object-cover"
            >
            {{-- Live Badge Overlay --}}
            @if($record->status === 'live')
                <div class="absolute top-3 left-3 flex items-center gap-2">
                    <div class="bg-red-600 text-white px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-2 animate-pulse">
                        <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                        LIVE
                    </div>
                </div>
            @endif
            {{-- Stream Button Overlay --}}
            @if($record->stream_url)
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-50 transition-all">
                    <a 
                        href="{{ $record->stream_url }}" 
                        target="_blank"
                        class="flex items-center justify-center w-20 h-20 bg-red-600 hover:bg-red-700 rounded-full transition-all transform hover:scale-110 shadow-2xl"
                    >
                        <svg class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </a>
                </div>
            @endif
            {{-- Status Badge --}}
            <div class="absolute bottom-3 right-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                    @if($record->status === 'live') bg-red-600 text-white
                    @elseif($record->status === 'scheduled') bg-yellow-500 text-white
                    @else bg-green-600 text-white
                    @endif">
                    {{ ucfirst($record->status) }}
                </span>
            </div>
        </div>
    @else
        <div class="relative rounded-lg overflow-hidden bg-gradient-to-br from-gray-700 to-gray-900 h-64 flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-400">No thumbnail available</p>
            </div>
        </div>
    @endif

    {{-- Match Title --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">{{ $record->title }}</h3>
        @if($record->description)
            <p class="text-gray-600 dark:text-gray-400">{{ $record->description }}</p>
        @endif
    </div>

    {{-- Teams Match-up --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
        <div class="flex items-center justify-between">
            {{-- Home Team --}}
            <div class="flex-1 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Home Team</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $record->team_home ?? 'TBA' }}
                </p>
            </div>

            {{-- VS Badge --}}
            <div class="mx-6">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-xl">VS</span>
                </div>
            </div>

            {{-- Away Team --}}
            <div class="flex-1 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Away Team</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $record->team_away ?? 'TBA' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Match Details --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Match Details</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $record->category }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Series</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($record->series === 'final') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($record->series === 'playoff') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                    @endif">
                    {{ ucfirst($record->series) }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Match Date</p>
                <p class="font-medium text-gray-900 dark:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $record->match_date->format('d F Y') }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                <p class="font-medium text-gray-900 dark:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $record->time }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Venue</p>
                <p class="font-medium text-gray-900 dark:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $record->venue }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Court</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->court }}</p>
            </div>
        </div>
    </div>

    {{-- Stream URL --}}
    @if($record->stream_url)
        <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="flex items-center justify-center w-10 h-10 bg-red-600 rounded-full flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Stream URL</p>
                        <p class="font-medium text-gray-900 dark:text-white text-sm truncate">
                            {{ $record->stream_url }}
                        </p>
                    </div>
                </div>
                <a 
                    href="{{ $record->stream_url }}" 
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium text-sm whitespace-nowrap ml-4"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                    </svg>
                    Watch Stream
                </a>
            </div>
        </div>
    @endif

    {{-- Status Info --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Match Status</p>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                @if($record->status === 'live') bg-red-600 text-white
                @elseif($record->status === 'scheduled') bg-yellow-500 text-white
                @else bg-green-600 text-white
                @endif">
                @if($record->status === 'live')
                    <span class="w-2 h-2 bg-white rounded-full animate-ping mr-2"></span>
                @endif
                {{ ucfirst($record->status) }}
            </span>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Visibility</p>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                {{ $record->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    {{-- Live Status Alert --}}
    @if($record->status === 'live')
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <div class="flex items-center justify-center w-6 h-6 bg-red-600 rounded-full flex-shrink-0 mt-0.5">
                    <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">Match is Currently Live!</h4>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                        This match is being broadcasted live right now. Click "Watch Stream" to view the live coverage.
                    </p>
                </div>
            </div>
        </div>
    @elseif($record->status === 'scheduled')
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Match Scheduled</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        This match is scheduled for {{ $record->match_date->format('d F Y') }} at {{ $record->time }}. The stream will go live shortly before the match starts.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Timestamps --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Created at</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Last updated</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>