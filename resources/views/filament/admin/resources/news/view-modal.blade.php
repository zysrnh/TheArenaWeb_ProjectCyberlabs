<div class="space-y-6">
    {{-- News Image --}}
    @if($record->image)
        <div class="flex justify-center">
            <div class="relative w-full rounded-lg overflow-hidden">
                <img 
                    src="{{ Storage::url($record->image) }}" 
                    alt="{{ $record->title }}"
                    class="w-full h-auto max-h-96 object-cover"
                >
            </div>
        </div>
    @else
        <div class="flex justify-center">
            <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada gambar</p>
                </div>
            </div>
        </div>
    @endif

    {{-- News Header Info --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-3 mb-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ match($record->category) {
                'News' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'Event' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                'Tournament' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                'Announcement' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            } }}">
                {{ $record->category }}
            </span>
            
            @if($record->is_featured)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Unggulan
                </span>
            @endif
            
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $record->is_published ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                {{ $record->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $record->title }}
        </h2>
        
        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $record->created_at->format('d F Y') }}</span>
            </div>
            
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>{{ number_format($record->views) }} views</span>
            </div>
        </div>
    </div>

    {{-- Excerpt --}}
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ringkasan
        </h3>
        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
            {{ $record->excerpt }}
        </p>
    </div>

    {{-- Content --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Konten Berita
        </h3>
        <div class="prose prose-sm dark:prose-invert max-w-none">
            {!! $record->content !!}
        </div>
    </div>

    {{-- Statistics Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total Views</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format($record->views) }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-lg p-4 border border-green-200 dark:border-green-700">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Status</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $record->is_published ? 'Published' : 'Draft' }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Category</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $record->category }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/30 dark:to-yellow-800/30 rounded-lg p-4 border border-yellow-200 dark:border-yellow-700">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Featured</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $record->is_featured ? 'Yes' : 'No' }}
            </p>
        </div>
    </div>

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