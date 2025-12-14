<div class="space-y-6 p-2">
    {{-- Equipment Information --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Nama Peralatan</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->name }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Kategori</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $record->category }}
                </span>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Harga Sewa</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                    {{ $record->formatted_price }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Per item per jam</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold {{ $record->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    @if($record->is_available)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Tersedia
                    @else
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Tidak Tersedia
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Deskripsi</h3>
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $record->description }}</p>
    </div>

    {{-- Equipment Image Gallery --}}
    @php
        $images = collect([
            $record->image_1,
            $record->image_2,
            $record->image_3,
            $record->image_4,
            $record->image_5
        ])->filter()->values();
    @endphp

    @if($images->count() > 0)
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-4">Galeri Gambar</h3>
            
            @if($images->count() === 1)
                {{-- Single Image - Large Display --}}
                <div class="relative group">
                    <img src="{{ Storage::url($images[0]) }}" 
                         alt="{{ $record->name }}" 
                         class="w-full h-auto rounded-lg shadow-lg object-contain bg-gray-50 dark:bg-gray-800"
                         style="max-height: 500px;">
                    <div class="absolute top-3 left-3">
                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-lg">
                            Gambar Utama
                        </span>
                    </div>
                </div>
            @else
                {{-- Multiple Images - Grid Display --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach($images as $index => $image)
                        <div class="relative group">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="{{ $record->name }}" 
                                 class="w-full h-48 object-cover rounded-lg shadow-md transition-transform group-hover:scale-[1.02] bg-gray-50 dark:bg-gray-800">
                            @if($index === 0)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-blue-600 text-white text-xs px-2.5 py-1 rounded-full font-semibold shadow-lg">
                                        Utama
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Availability Alert --}}
    @if(!$record->is_available)
        <div class="bg-red-50 dark:bg-red-900/10 border-2 border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-red-800 dark:text-red-200 mb-1">Peralatan Tidak Tersedia</h4>
                    <p class="text-sm text-red-700 dark:text-red-300">
                        Peralatan ini saat ini tidak tersedia untuk disewa. Aktifkan status ketersediaan untuk menampilkannya di halaman booking.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Timestamps --}}
    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Dibuat Pada</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->created_at->format('H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Terakhir Update</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->updated_at->format('H:i') }} WIB</p>
            </div>
        </div>
    </div>
</div>