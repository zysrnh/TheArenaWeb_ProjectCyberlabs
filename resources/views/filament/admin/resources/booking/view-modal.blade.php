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

    {{-- Booking Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Booking</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Booking</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->booking_date->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Lapangan</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->venue_type === 'indoor' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                    {{ ucfirst($record->venue_type) }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    @if($record->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($record->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($record->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @endif">
                    {{ ucfirst($record->status) }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->is_paid ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ $record->is_paid ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Time Slots --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Slot Waktu Booking</h3>
        @php
            $timeSlots = $record->time_slots;
            $hasSlots = is_array($timeSlots) && count($timeSlots) > 0;
        @endphp
        
        @if($hasSlots)
            <div class="space-y-2">
                @foreach($timeSlots as $index => $slot)
                    @php
                        $time = $slot['time'] ?? '-';
                        $duration = $slot['duration'] ?? 120;
                        $price = $slot['price'] ?? 0;
                    @endphp
                    <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-semibold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $time }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $duration }} menit</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada slot waktu</p>
        @endif
    </div>

    {{-- Price Summary --}}
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-4">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Total Pembayaran</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($record->total_price, 0, ',', '.') }}</p>
            </div>
            @if(is_array($record->time_slots))
                <div class="text-right">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Total Slot</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ count($record->time_slots) }} Slot</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Payment Info Alert (Only show if not paid) --}}
    @if(!$record->is_paid)
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Menunggu Pembayaran</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        Booking ini belum dikonfirmasi pembayarannya. Klik tombol "Konfirmasi Pembayaran" di bawah jika pembayaran sudah diterima.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Notes --}}
    @if($record->notes)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Catatan</h3>
            <p class="text-gray-700 dark:text-gray-300">{{ $record->notes }}</p>
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