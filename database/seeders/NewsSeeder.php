<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $newsData = [
            [
                'title' => 'Pertandingan Sengit Antara Prawira Bandung dan Pelita Jaya Berakhir Dramatis',
                'excerpt' => 'Pertandingan basket yang berlangsung malam ini menampilkan duel sengit antara dua tim kuat di liga nasional.',
                'content' => '<p>Pertandingan basket yang berlangsung malam ini menampilkan duel sengit antara dua tim kuat di liga nasional. Prawira Bandung berhasil mengalahkan Pelita Jaya dengan skor tipis 100-99.</p><p>Pertandingan berjalan ketat sejak kuarter pertama dengan kedua tim saling unggul bergantian. Pada menit-menit terakhir, Prawira Bandung berhasil membalikkan keadaan dengan three-pointer spektakuler dari pemain andalannya.</p><p>Penonton yang memadati stadion memberikan standing ovation untuk penampilan luar biasa kedua tim. Ini merupakan pertandingan terbaik musim ini.</p>',
                'category' => 'News',
                'is_published' => true,
                'is_featured' => true,
                'views' => 2100,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Turnamen Basket Antar Sekolah Dimulai Pekan Depan',
                'excerpt' => 'Turnamen basket tingkat SMP se-Jakarta akan dimulai pekan depan dengan diikuti 32 tim sekolah.',
                'content' => '<p>Turnamen basket tingkat SMP se-Jakarta akan dimulai pekan depan dengan diikuti 32 tim sekolah. Pertandingan akan berlangsung selama 2 minggu penuh di berbagai venue di Jakarta.</p><p>Turnamen ini diselenggarakan sebagai ajang pencarian bibit muda berbakat dan meningkatkan minat olahraga basket di kalangan pelajar.</p><p>Pendaftaran telah ditutup dengan antusiasme yang luar biasa dari berbagai sekolah. Total hadiah yang diperebutkan mencapai Rp 50 juta.</p>',
                'category' => 'Tournament',
                'is_published' => true,
                'is_featured' => true,
                'views' => 890,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'Pelatih Tim Nasional Umumkan Skuad Baru untuk SEA Games',
                'excerpt' => 'Pelatih tim nasional basket Indonesia mengumumkan 12 pemain yang akan memperkuat tim di ajang SEA Games.',
                'content' => '<p>Pelatih tim nasional basket Indonesia mengumumkan 12 pemain yang akan memperkuat tim di ajang SEA Games mendatang. Skuad ini merupakan kombinasi pemain senior dan junior yang dipilih melalui proses seleksi ketat.</p><p>Dalam konferensi pers, pelatih menyatakan optimisme tinggi untuk meraih medali emas di ajang bergengsi tersebut.</p><p>Tim akan menjalani training camp intensif selama 1 bulan sebelum keberangkatan.</p>',
                'category' => 'News',
                'is_published' => true,
                'is_featured' => false,
                'views' => 3200,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'Fasilitas Lapangan Basket Baru Dibuka di Jakarta Selatan',
                'excerpt' => 'Sebuah fasilitas lapangan basket indoor dengan standar internasional resmi dibuka untuk umum.',
                'content' => '<p>Sebuah fasilitas lapangan basket indoor dengan standar internasional resmi dibuka untuk umum di kawasan Jakarta Selatan. Fasilitas ini dilengkapi dengan tribun berkapasitas 500 orang dan sistem pencahayaan modern.</p><p>Lapangan ini tersedia untuk disewa untuk latihan, pertandingan, dan event basket lainnya dengan harga yang terjangkau.</p><p>Grand opening dihadiri oleh berbagai tokoh olahraga dan pejabat pemerintah.</p>',
                'category' => 'Announcement',
                'is_published' => true,
                'is_featured' => false,
                'views' => 1800,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'title' => 'Pemain Muda Indonesia Raih MVP di Turnamen Asia',
                'excerpt' => 'Pemain muda berbakat Indonesia berhasil meraih penghargaan Most Valuable Player di turnamen basket tingkat Asia.',
                'content' => '<p>Pemain muda berbakat Indonesia berhasil meraih penghargaan Most Valuable Player (MVP) dalam turnamen basket tingkat Asia yang berlangsung di Thailand.</p><p>Dengan rata-rata 28.5 poin, 8.2 rebound, dan 6.7 assist per game, pemain berusia 19 tahun ini menjadi sorotan di turnamen tersebut.</p><p>Prestasi ini diharapkan dapat memotivasi pemain muda lainnya untuk terus berlatih dan berkembang.</p>',
                'category' => 'News',
                'is_published' => true,
                'is_featured' => true,
                'views' => 2800,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Workshop Pelatihan Basket untuk Pelatih Muda Digelar',
                'excerpt' => 'Federasi Basket Indonesia menggelar workshop pelatihan untuk pelatih-pelatih muda di seluruh Indonesia.',
                'content' => '<p>Federasi Basket Indonesia menggelar workshop pelatihan untuk pelatih-pelatih muda di seluruh Indonesia. Program ini bertujuan meningkatkan kualitas pelatih di tingkat grassroot.</p><p>Workshop akan menghadirkan pelatih bersertifikat internasional dan berlangsung selama 3 hari.</p><p>Peserta akan mendapatkan sertifikat resmi setelah menyelesaikan program.</p>',
                'category' => 'Event',
                'is_published' => true,
                'is_featured' => false,
                'views' => 1100,
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }
    }
}