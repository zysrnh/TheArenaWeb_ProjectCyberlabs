<div class="space-y-6">
    {{-- Header Info --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $record->title ?: 'Tanpa Judul' }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Section: 
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        @if($record->section_key === 'hero') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($record->section_key === 'arena') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($record->section_key === 'komunitas') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($record->section_key === 'tribun') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                        @endif">
                        {{ ucfirst($record->section_key) }}
                    </span>
                </p>
            </div>
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ $record->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Basic Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h4 class="text-md font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Informasi Dasar
        </h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Judul</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->title ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Sub Judul</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->subtitle ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Urutan</p>
                <p class="font-medium text-gray-900 dark:text-white">#{{ $record->order }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                <p class="font-medium {{ $record->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $record->is_active ? 'Aktif' : 'Nonaktif' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Image Preview --}}
    @if($record->image_url)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h4 class="text-md font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Gambar
            </h4>
            <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                @php
                    $imageUrl = $record->image_url;
                    // Jika bukan URL external, tambahkan /storage/
                    if (!str_starts_with($imageUrl, 'http')) {
                        $imageUrl = asset('storage/' . $imageUrl);
                    }
                @endphp
                <img 
                    src="{{ $imageUrl }}" 
                    alt="{{ $record->title }}" 
                    class="w-full h-64 object-cover"
                    onerror="this.src='https://via.placeholder.com/800x400?text=Image+Not+Found'"
                >
            </div>
        </div>
    @endif

    {{-- Content Description --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h4 class="text-md font-semibold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Konten Deskripsi
        </h4>
        
        <div class="space-y-4">
            @if($record->description_1)
                <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold">1</span>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi 1</p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed ml-8">{{ $record->description_1 }}</p>
                </div>
            @endif

            @if($record->description_2)
                <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold">2</span>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi 2</p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed ml-8">{{ $record->description_2 }}</p>
                </div>
            @endif

            @if($record->description_3)
                <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs font-semibold">3</span>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi 3</p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed ml-8">{{ $record->description_3 }}</p>
                </div>
            @endif

            @if(!$record->description_1 && !$record->description_2 && !$record->description_3)
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm">Tidak ada deskripsi konten</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Timestamps --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Dibuat pada
                </p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Terakhir diupdate
                </p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ strlen($record->description_1 ?? '') + strlen($record->description_2 ?? '') + strlen($record->description_3 ?? '') }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Total Karakter</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $record->image_url ? '✓' : '✗' }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Gambar</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $record->order }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Urutan</p>
            </div>
        </div>
    </div>
</div>