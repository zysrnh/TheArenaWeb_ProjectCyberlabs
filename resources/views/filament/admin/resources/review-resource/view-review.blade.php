<div class="space-y-6">
    {{-- Client Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Client</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Nama Client</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->client->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->client->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Telepon</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->client->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->client->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Review Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Review</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">ID Review</p>
                <p class="font-medium text-gray-900 dark:text-white">#{{ $record->id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Rating</p>
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-xl {{ $i <= $record->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">
                            ⭐
                        </span>
                    @endfor
                    <span class="ml-2 text-sm font-semibold text-gray-900 dark:text-white">({{ $record->rating }}/5)</span>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat pada</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Terakhir Diupdate</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Comment --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Komentar</h3>
        <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $record->comment }}</p>
        </div>
    </div>

    {{-- Booking Information --}}
    @if($record->booking)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Booking Terkait</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ID Booking</p>
                    <p class="font-medium text-gray-900 dark:text-white">#{{ $record->booking->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Booking</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $record->booking->booking_date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Lapangan</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->booking->venue_type === 'indoor' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                        {{ ucfirst($record->booking->venue_type) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Harga</p>
                    <p class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($record->booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Tidak Ada Booking Terkait</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        Review ini tidak memiliki booking terkait atau booking telah dihapus.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Timestamps Detail --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Dibuat pada</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y H:i') }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $record->created_at->diffForHumans() }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Terakhir diupdate</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y H:i') }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $record->updated_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>