<div class="space-y-6">
    {{-- Thumbnail Preview --}}
    @if($record->thumbnail)
        <div class="relative rounded-lg overflow-hidden bg-gray-900">
            <img 
                src="{{ Storage::url($record->thumbnail) }}" 
                alt="{{ $record->title }}"
                class="w-full h-auto object-cover"
            >
            {{-- Play Button Overlay (jika ada video_url) --}}
            @if($record->video_url)
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-50 transition-all">
                    <a 
                        href="{{ $record->video_url }}" 
                        target="_blank"
                        class="flex items-center justify-center w-16 h-16 bg-red-600 hover:bg-red-700 rounded-full transition-all transform hover:scale-110"
                    >
                        <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </a>
                </div>
            @endif
            {{-- Duration Badge --}}
            <div class="absolute bottom-3 right-3 bg-black bg-opacity-75 text-white px-2 py-1 rounded text-sm font-medium">
                {{ $record->duration }}
            </div>
            {{-- Featured Badge --}}
            @if($record->is_featured)
                <div class="absolute top-3 left-3 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    FEATURED
                </div>
            @endif
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

    {{-- Highlight Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">{{ $record->title }}</h3>
        @if($record->description)
            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $record->description }}</p>
        @endif

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Match</p>
                <p class="font-semibold text-gray-900 dark:text-white">
                    {{ $record->game->team1->name }} vs {{ $record->game->team2->name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $record->game->date->format('d F Y') }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Score</p>
                <p class="font-bold text-xl text-gray-900 dark:text-white">
                    {{ $record->game->score ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Stats & Details --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Highlight Details</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if($record->quarter === 'Full Highlights') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif(in_array($record->quarter, ['Best Plays', 'Top 5 Plays'])) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($record->quarter === 'Game Winner') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @endif">
                    {{ $record->quarter }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                <p class="font-medium text-gray-900 dark:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $record->duration }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Views</p>
                <p class="font-medium text-gray-900 dark:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($record->views) }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $record->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ ucfirst($record->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Video Link --}}
    @if($record->video_url)
        <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-red-600 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Video URL</p>
                        <p class="font-medium text-gray-900 dark:text-white text-sm truncate max-w-xs">
                            {{ $record->video_url }}
                        </p>
                    </div>
                </div>
                <a 
                    href="{{ $record->video_url }}" 
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium text-sm"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                    </svg>
                    Watch Video
                </a>
            </div>
        </div>
    @endif

    {{-- Match Details --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Match Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">League</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->game->league }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Series</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->game->series }}</p>
            </div>
            @if($record->game->venue)
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Venue</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $record->game->venue }}</p>
                </div>
            @endif
            @if($record->game->region)
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Region</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $record->game->region }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Featured Badge Info --}}
    @if($record->is_featured)
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Featured Highlight</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        This highlight is featured and will be displayed prominently on the homepage.
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