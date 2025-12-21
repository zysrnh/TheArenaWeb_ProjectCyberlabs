<div class="space-y-6">
    {{-- Client Info --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Pengunjung</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Client</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->client ? $record->client->name : '🌐 Anonim' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->client?->email ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">IP Address</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->ip_address }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Session ID</p>
                <p class="font-medium text-gray-900 dark:text-white font-mono text-xs">{{ $record->session_id }}</p>
            </div>
        </div>
    </div>

    {{-- Visit Info --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Detail Kunjungan</h3>
        <div class="space-y-3">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">URL</p>
                <p class="font-medium text-gray-900 dark:text-white break-all">{{ $record->url }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Method</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $record->method }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">User Agent</p>
                <p class="font-medium text-gray-900 dark:text-white text-sm break-all">{{ $record->user_agent }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Waktu Kunjungan</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->visited_at->format('d F Y H:i:s') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $record->visited_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
</div>