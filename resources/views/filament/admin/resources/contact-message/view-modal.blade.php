<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 rounded-lg p-6 text-white">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-bold">{{ $record->subject }}</h2>
        </div>
        <p class="text-sm opacity-90">
            Diterima pada {{ $record->created_at->format('d M Y, H:i') }} WIB
        </p>
    </div>

    {{-- Informasi Pengirim --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-5">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Informasi Pengirim
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nama</label>
                <p class="text-gray-900 dark:text-white font-semibold">{{ $record->nama }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Email</label>
                <p class="text-gray-900 dark:text-white font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $record->email }}
                </p>
            </div>
        </div>
    </div>

    {{-- Isi Pesan --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-5">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            Isi Pesan
        </h3>
        <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">{{ $record->pesan }}</p>
        </div>
    </div>

    {{-- Balasan Admin (jika ada) --}}
    @if($record->admin_reply)
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold mb-3 text-blue-900 dark:text-blue-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                Balasan Admin
            </h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">{{ $record->admin_reply }}</p>
            </div>
            @if($record->replied_at)
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-3">
                    Dibalas pada: {{ $record->replied_at->format('d M Y, H:i') }} WIB
                </p>
            @endif
        </div>
    @endif

    {{-- Timeline --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-5">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Timeline
        </h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Pesan Diterima</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $record->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            
            @if($record->read_at)
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dibaca</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $record->read_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
            @endif

            @if($record->replied_at)
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dibalas</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $record->replied_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>