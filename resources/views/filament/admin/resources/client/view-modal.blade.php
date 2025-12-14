<div class="space-y-6">
    {{-- Profile Image --}}
    @if($record->profile_image)
        <div class="flex justify-center">
            <div class="relative">
                <img 
                    src="{{ Storage::url($record->profile_image) }}" 
                    alt="{{ $record->name }}"
                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700"
                >
            </div>
        </div>
    @endif

    {{-- Personal Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Pribadi</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">No. Telepon</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</p>
                @if($record->gender)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->gender === 'male' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' }}">
                        {{ ucfirst($record->gender) }}
                    </span>
                @else
                    <p class="font-medium text-gray-900 dark:text-white">-</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->birth_date ? $record->birth_date->format('d F Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Usia</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->birth_date ? $record->birth_date->age . ' tahun' : '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Address Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Informasi Alamat</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Provinsi</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->province ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kota</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->city ?? '-' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">Alamat Lengkap</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Account Statistics --}}
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Statistik Akun</h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-300">Total Booking</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $record->bookings()->count() }}
                </p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-300">Booking Aktif</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $record->bookings()->whereIn('status', ['pending', 'confirmed'])->count() }}
                </p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-300">Booking Selesai</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $record->bookings()->where('status', 'completed')->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    @php
        $recentBookings = $record->bookings()->latest()->take(5)->get();
    @endphp
    
    @if($recentBookings->count() > 0)
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Riwayat Booking Terbaru</h3>
            <div class="space-y-2">
                @foreach($recentBookings as $booking)
                    <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $booking->booking_date->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ ucfirst(str_replace('_', ' ', $booking->venue_type)) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Timestamps --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Terdaftar pada</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Terakhir diupdate</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>