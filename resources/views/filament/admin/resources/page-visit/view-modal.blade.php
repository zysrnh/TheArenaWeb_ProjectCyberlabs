<div class="space-y-6">
    {{-- Date Header --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tanggal Kunjungan</p>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $record->visit_date->format('l, d F Y') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $record->visit_date->diffForHumans() }}
                </p>
            </div>
            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Main Statistics --}}
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-lg p-8 border border-green-200 dark:border-green-700 text-center">
        <div class="flex items-center justify-center mb-4">
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Total Pengunjung</p>
        <p class="text-6xl font-bold text-gray-900 dark:text-white mb-2">
            {{ number_format($record->total_visits) }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">pengunjung unik</p>
    </div>

    {{-- Growth Comparison --}}
    @php
        $previous = App\Models\PageVisit::where('visit_date', '<', $record->visit_date)
            ->orderBy('visit_date', 'desc')
            ->first();
        
        $diff = 0;
        $percentage = 0;
        $growthType = 'neutral';
        
        if ($previous) {
            $diff = $record->total_visits - $previous->total_visits;
            $percentage = $previous->total_visits > 0 
                ? round(($diff / $previous->total_visits) * 100, 1) 
                : 0;
            
            if ($diff > 0) {
                $growthType = 'positive';
            } elseif ($diff < 0) {
                $growthType = 'negative';
            }
        }
    @endphp

    @if($previous)
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Perbandingan dengan Hari Sebelumnya
        </h3>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="text-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Hari Sebelumnya</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $previous->visit_date->format('d M Y') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($previous->total_visits) }}</p>
            </div>
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Hari Ini</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $record->visit_date->format('d M Y') }}</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($record->total_visits) }}</p>
            </div>
        </div>

        <div class="flex items-center justify-center gap-2 p-4 rounded-lg {{ $growthType === 'positive' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700' : ($growthType === 'negative' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700' : 'bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700') }}">
            @if($growthType === 'positive')
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="text-2xl font-bold text-green-600 dark:text-green-400">
                    +{{ number_format(abs($diff)) }} ({{ $percentage >= 0 ? '+' : '' }}{{ $percentage }}%)
                </span>
            @elseif($growthType === 'negative')
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
                <span class="text-2xl font-bold text-red-600 dark:text-red-400">
                    {{ number_format($diff) }} ({{ $percentage }}%)
                </span>
            @else
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                </svg>
                <span class="text-2xl font-bold text-gray-600 dark:text-gray-400">
                    Tidak Ada Perubahan
                </span>
            @endif
        </div>
    </div>
    @else
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <p class="text-sm text-blue-900 dark:text-blue-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Ini adalah data pertama, tidak ada perbandingan.
        </p>
    </div>
    @endif

    {{-- Statistics Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        {{-- Daily Average (Last 7 Days) --}}
        @php
            $last7Days = App\Models\PageVisit::where('visit_date', '>=', now()->subDays(7))
                ->where('visit_date', '<=', $record->visit_date)
                ->avg('total_visits');
        @endphp
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Rata-rata 7 Hari</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format(round($last7Days)) }}
            </p>
        </div>

        {{-- Highest This Month --}}
        @php
            $highestThisMonth = App\Models\PageVisit::whereYear('visit_date', $record->visit_date->year)
                ->whereMonth('visit_date', $record->visit_date->month)
                ->max('total_visits');
        @endphp
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-lg p-4 border border-orange-200 dark:border-orange-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tertinggi Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format($highestThisMonth) }}
            </p>
        </div>

        {{-- This Month Total --}}
        @php
            $monthTotal = App\Models\PageVisit::whereYear('visit_date', $record->visit_date->year)
                ->whereMonth('visit_date', $record->visit_date->month)
                ->sum('total_visits');
        @endphp
        <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/30 dark:to-cyan-800/30 rounded-lg p-4 border border-cyan-200 dark:border-cyan-700">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format($monthTotal) }}
            </p>
        </div>
    </div>

    {{-- Performance Category --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Kategori Performa
        </h3>
        
        @php
            $performanceLevel = match(true) {
                $record->total_visits >= 100 => ['level' => 'Luar Biasa', 'color' => 'green', 'icon' => '🚀'],
                $record->total_visits >= 50 => ['level' => 'Sangat Baik', 'color' => 'blue', 'icon' => '⭐'],
                $record->total_visits >= 25 => ['level' => 'Baik', 'color' => 'yellow', 'icon' => '👍'],
                $record->total_visits >= 10 => ['level' => 'Cukup', 'color' => 'orange', 'icon' => '📊'],
                default => ['level' => 'Perlu Ditingkatkan', 'color' => 'red', 'icon' => '📉']
            };
        @endphp
        
        <div class="p-6 rounded-lg bg-{{ $performanceLevel['color'] }}-50 dark:bg-{{ $performanceLevel['color'] }}-900/20 border border-{{ $performanceLevel['color'] }}-200 dark:border-{{ $performanceLevel['color'] }}-700">
            <div class="text-center">
                <div class="text-5xl mb-3">{{ $performanceLevel['icon'] }}</div>
                <h4 class="text-2xl font-bold text-{{ $performanceLevel['color'] }}-900 dark:text-{{ $performanceLevel['color'] }}-200 mb-2">
                    {{ $performanceLevel['level'] }}
                </h4>
                <p class="text-sm text-{{ $performanceLevel['color'] }}-700 dark:text-{{ $performanceLevel['color'] }}-300">
                    @if($record->total_visits >= 100)
                        Traffic sangat tinggi! Website Anda mendapat perhatian besar hari ini.
                    @elseif($record->total_visits >= 50)
                        Performa yang sangat baik! Terus pertahankan momentum ini.
                    @elseif($record->total_visits >= 25)
                        Traffic yang solid. Ada ruang untuk peningkatan lebih lanjut.
                    @elseif($record->total_visits >= 10)
                        Traffic cukup stabil. Pertimbangkan strategi pemasaran lebih aktif.
                    @else
                        Traffic masih rendah. Tingkatkan promosi dan konten berkualitas.
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Timestamps --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400 mb-1">Data dibuat</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->created_at->format('d F Y H:i') }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400 mb-1">Terakhir diupdate</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->updated_at->format('d F Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>