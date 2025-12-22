import { Head, Link, usePage, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { ChevronRight, Phone, Mail, LogOut } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import Contact from '../../Components/Contact';

export default function HomePage() {
  // Destructure props dengan default values
  const {
  auth,
  liveMatches = [],
  homeMatches = [],
  currentFilter = 'all',
  newsForHome = [],
  sponsors = [],        // ✅ TAMBAH INI
  partners = []         // ✅ TAMBAH INI
} = usePage().props;

  const [currentSlide, setCurrentSlide] = useState(0);
  const [isScrolled, setIsScrolled] = useState(false);
  const [lastScrollY, setLastScrollY] = useState(0);
  const [showContactBar, setShowContactBar] = useState(false);
  const [filter, setFilter] = useState(currentFilter || 'all');

  const handleFilterChange = (newFilter) => {
    setFilter(newFilter);
    router.get('/', { filter: newFilter }, {
      preserveState: true,
      preserveScroll: true,
    });
  };

  useEffect(() => {
    const handleScroll = () => {
      const currentScrollY = window.scrollY;
      setIsScrolled(currentScrollY > 50);

      if (currentScrollY > lastScrollY && currentScrollY > 50) {
        setShowContactBar(true);
      } else if (currentScrollY < lastScrollY || currentScrollY <= 50) {
        setShowContactBar(false);
      }

      setLastScrollY(currentScrollY);
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, [lastScrollY]);

  const slides = [
    {
      title: "BOOKING LAPANGAN SEKARANG!",
      subtitle: "The Arena Basketball",
      description:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
      image: "https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200",
    },
    {
      title: "FASILITAS TERBAIK UNTUK ANDA!",
      subtitle: "The Arena Basketball",
      description:
        "Nikmati pengalaman bermain basket dengan fasilitas lengkap dan modern. Lapangan standar internasional dengan pencahayaan optimal untuk permainan terbaik Anda.",
      image:
        "https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1200",
    },
    {
      title: "JADWALKAN PERTANDINGAN ANDA!",
      subtitle: "The Arena Basketball",
      description:
        "Tersedia berbagai pilihan waktu untuk latihan tim, pertandingan persahabatan, atau turnamen. Booking mudah dan cepat melalui sistem online kami.",
      image:
        "https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1200",
    },
  ];

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev + 1) % slides.length);
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length);
  };

  const handleLogout = () => {
    if (confirm('Apakah Anda yakin ingin keluar?')) {
      router.post('/logout');
    }
  };

  return (
    <>
      <Head title="THE ARENA - Home Page" />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
      `}</style>
      <div className="min-h-screen flex flex-col bg-[#013064]">
        {/* Navigation - RESPONSIVE & STICKY */}
        <Navigation activePage="home" />

        {/* Hero Section with Carousel - RESPONSIVE */}
        <main className="flex-1 relative">
          <div className="relative h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden">
            <div
              className="absolute inset-0 bg-cover bg-center"
              style={{
                backgroundImage: `url('${slides[currentSlide].image}')`,
                filter: "brightness(0.4)",
              }}
            />

            <div className="relative z-10 h-full flex items-center justify-center">
              <div className="text-center text-white px-4 max-w-4xl">
                <h2 className="text-[#FDB913] text-lg md:text-xl lg:text-2xl font-semibold mb-2">
                  {slides[currentSlide].subtitle}
                </h2>
                <h1 className="text-2xl md:text-4xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
                  {slides[currentSlide].title}
                </h1>
                <p className="text-sm md:text-base lg:text-lg mb-6 md:mb-8 text-gray-200 max-w-2xl mx-auto leading-relaxed">
                  {slides[currentSlide].description}
                </p>
                <Link href="/booking">
                  <button className="bg-[#ffd22f] text-[#013064] px-6 md:px-8 py-2 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit">
                    Booking Lapangan
                  </button>
                </Link>
              </div>

              <button
                onClick={prevSlide}
                className="absolute left-4 md:left-24 lg:left-32 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 flex items-center justify-center"
              >
                <img
                  src="/images/Kiri.svg"
                  alt="Previous"
                  className="w-full h-full"
                />
              </button>
              <button
                onClick={nextSlide}
                className="absolute right-4 md:right-24 lg:right-32 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 flex items-center justify-center"
              >
                <img
                  src="/images/Kanan.svg"
                  alt="Next"
                  className="w-full h-full"
                />
              </button>
            </div>
          </div>
        </main>

        {/* Social Media Section - RESPONSIVE */}
        <div className="bg-[#ffd22f] py-4 md:py-6">
          <div className="max-w-7xl mx-auto px-4 flex justify-center md:justify-end items-center gap-3 md:gap-4">
            <a href="#" className="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center">
              <img
                src="/images/instagram.png"
                alt="Instagram"
                className="w-full h-full object-contain"
              />
            </a>
            <a href="#" className="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center">
              <img
                src="/images/tiktok.png"
                alt="TikTok"
                className="w-full h-full object-contain"
              />
            </a>
            <a href="#" className="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center">
              <img
                src="/images/youtube.png"
                alt="YouTube"
                className="w-full h-full object-contain"
              />
            </a>
            <a href="#" className="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center">
              <img
                src="/images/whatsapp.png"
                alt="WhatsApp"
                className="w-full h-full object-contain"
              />
            </a>
          </div>
        </div>

        {/* Content Sections - RESPONSIVE */}
        <div className="bg-white">
          {/* Section 1: Penyewaan Lapangan Basket */}
          <div className="grid md:grid-cols-2">
            <div className="relative h-full min-h-[300px] md:min-h-[400px]">
              <img
                src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200"
                alt="Basketball Court"
                className="w-full h-full object-cover"
              />
            </div>

            <div className="bg-[#003f84] text-white p-6 md:p-12 lg:p-16 flex flex-col justify-center">
              <h3 className="text-[#ffd22f] text-lg md:text-xl lg:text-2xl font-semibold mb-3 md:mb-4">
                Penyewaan Lapangan Basket
              </h3>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 leading-tight">
                Penyewaan Lapangan Basket
              </h2>
              <p className="text-gray-300 text-sm md:text-base mb-6 md:mb-8 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
              </p>
              <Link href="/booking">
                <button className="bg-[#ffd22f] text-[#013064] px-6 md:px-8 py-2 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit">
                  Booking Lapangan
                  <ChevronRight className="w-4 h-4" />
                </button>
              </Link>
            </div>
          </div>

          {/* Section 2: Penyewaan Perlengkapan Basket */}
          <div className="grid md:grid-cols-2">
            <div className="bg-[#003f84] text-white p-6 md:p-12 lg:p-16 flex flex-col justify-center order-2 md:order-1">
              <h3 className="text-[#ffd22f] text-lg md:text-xl lg:text-2xl font-semibold mb-3 md:mb-4">
                Perlengkapan
              </h3>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 leading-tight">
                Penyewaan Perlengkapan Basket
              </h2>
              <p className="text-gray-300 text-sm md:text-base mb-6 md:mb-8 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
              </p>
              <button className="bg-[#ffd22f] text-[#013064] px-6 md:px-8 py-2 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit"
                onClick={() => router.visit('/booking-peralatan')}>
                Booking Peralatan
                <ChevronRight className="w-4 h-4" />
              </button>
            </div>

            <div className="relative h-full min-h-[300px] md:min-h-[400px] order-1 md:order-2">
              <img
                src="https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1200"
                alt="Basketball Equipment"
                className="w-full h-full object-cover"
              />
            </div>
          </div>

          {/* Section 3: Event Organizer */}
          <div className="grid md:grid-cols-2">
            <div className="relative h-full min-h-[300px] md:min-h-[400px]">
              <img
                src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200"
                alt="Basketball Court"
                className="w-full h-full object-cover"
              />
            </div>

            <div className="bg-[#003f84] text-white p-6 md:p-12 lg:p-16 flex flex-col justify-center">
              <h3 className="text-[#ffd22f] text-lg md:text-xl lg:text-2xl font-semibold mb-3 md:mb-4">
                Event Organizer
              </h3>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 leading-tight">
                Penyewaan Acara Basket
              </h2>
              <p className="text-gray-300 text-sm md:text-base mb-6 md:mb-8 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
              </p>
              <Link href="/kontak">
                <button className="bg-[#ffd22f] text-[#013064] px-6 md:px-8 py-2 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit">
                  Hubungi Kami
                  <ChevronRight className="w-4 h-4" />
                </button>
              </Link>
            </div>
          </div>
        </div>

        {/* Berita Seputar Basket Section - RESPONSIVE */}
        <div className="bg-[#013064] py-12 md:py-16 lg:py-20 px-4">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-10 md:mb-16">
              <p className="text-[#ffd22f] text-base md:text-xl lg:text-2xl font-semibold mb-2 md:mb-3">Berita</p>
              <h2 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold">Berita Seputar Basket</h2>
            </div>

            {newsForHome && newsForHome.length > 0 ? (
              <>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
                  {newsForHome.map((news) => (
                    <Link key={news.id} href={`/berita/${news.id}`} className="block">
                      <div className="group cursor-pointer overflow-hidden relative h-[320px] md:h-[360px] lg:h-[380px]">
                        <img
                          src={news.image}
                          alt={news.title}
                          className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                          onError={(e) => {
                            e.target.src = 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800';
                          }}
                        />
                        <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />
                        <span className="absolute top-3 left-3 bg-[#e74c3c] text-white px-2.5 py-1 text-xs font-semibold z-10">
                          {news.category}
                        </span>
                        <div className="absolute bottom-0 left-0 right-0 p-4 md:p-5 text-white">
                          <p className="text-gray-300 text-xs mb-2">{news.category} - {news.date}</p>
                          <h3 className="text-white text-sm md:text-base font-bold mb-2 leading-tight line-clamp-2">
                            {news.title}
                          </h3>
                          <p className="text-gray-200 text-xs mb-3 leading-relaxed line-clamp-2">
                            {news.excerpt}
                          </p>
                          <span className="text-white text-xs font-semibold flex items-center gap-1.5 group-hover:text-[#ffd22f] transition">
                            Lihat selengkapnya
                            <ChevronRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                          </span>
                        </div>
                      </div>
                    </Link>
                  ))}
                </div>

                <div className="text-center">
                  <Link href="/berita">
                    <button className="bg-[#ffd22f] text-[#013064] px-8 md:px-10 py-2.5 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition">
                      Lihat Lebih Banyak
                    </button>
                  </Link>
                </div>
              </>
            ) : (
              <div className="text-center py-12">
                <p className="text-white text-xl">Belum ada berita tersedia</p>
              </div>
            )}
          </div>
        </div>
        {/* Promo Section - Hero Banner - RESPONSIVE */}
        <div className="relative h-[350px] md:h-[450px] lg:h-[500px] overflow-hidden">
          <img
            src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1600"
            alt="Basketball Promo"
            className="w-full h-full object-cover"
          />

          <div className="absolute inset-0 bg-black/60" />

          <div className="absolute inset-0 flex items-center">
            <div className="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 w-full">
              <div className="max-w-3xl text-white">
                <span className="text-[#ffd22f] text-base md:text-xl lg:text-2xl font-semibold mb-2 md:mb-3 block">
                  Promo
                </span>

                <h2 className="text-2xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-5 leading-tight">
                  Main Sekarang, Bayar Murah! Lapangan Basket Premium Mulai
                  Rp100.000/Jam
                </h2>

                <div className="mb-5 md:mb-6 space-y-1 text-sm md:text-base lg:text-lg">
                  <p>Mulai Rp100.000/jam (weekday)</p>
                  <p>Weekend hanya Rp130.000/jam</p>
                </div>

                <button className="bg-[#ffd22f] text-[#013064] px-5 md:px-7 py-2 md:py-3 text-xs md:text-sm lg:text-base font-bold hover:bg-[#ffe066] transition inline-flex items-center gap-2">
                  Booking Sekarang
                  <ChevronRight className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Fasilitas Section - RESPONSIVE */}
        <div className="bg-white">
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            {/* Fasilitas 1 */}
            <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
              <img
                src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800"
                alt="Food & Beverage"
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                <span className="text-[#ffd22f] text-sm md:text-base lg:text-lg font-semibold mb-1 md:mb-2 block">
                  Fasilitas
                </span>
                <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                  Makanan & Minuman
                </h3>
              </div>
            </div>

            {/* Fasilitas 2 */}
            <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
              <img
                src="https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=800"
                alt="Storage Lockers"
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                <span className="text-[#ffd22f] text-sm md:text-base lg:text-lg font-semibold mb-1 md:mb-2 block">
                  Fasilitas
                </span>
                <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                  Penitipan Barang
                </h3>
              </div>
            </div>

            {/* Fasilitas 3 */}
            <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
              <img
                src="https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=800"
                alt="Restroom & Shower"
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                <span className="text-[#ffd22f] text-sm md:text-base lg:text-lg font-semibold mb-1 md:mb-2 block">
                  Fasilitas
                </span>
                <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                  Toilet dan Kamar Mandi
                </h3>
              </div>
            </div>
          </div>
        </div>

        <div className="bg-[#ffd22f] py-6">
          <div className="max-w-7xl mx-auto px-4 flex justify-end items-center gap-4"></div>
        </div>

        {/* Jadwal Pertandingan Section - RESPONSIVE */}
        <div className="bg-[#013064] py-12 md:py-16 px-4">
          <div className="max-w-7xl mx-auto">
            {/* Section Header with Filter Buttons */}
            <div className="text-center mb-8 md:mb-12">
              <p className="text-[#ffd22f] text-base md:text-xl lg:text-2xl font-semibold mb-2 md:mb-3">
                Jadwal
              </p>
              <h2 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold mb-6 md:mb-8">
                Jadwal Pertandingan Basket
              </h2>

              {/* Filter Buttons - Updated Design */}
              <div className="flex flex-wrap justify-center gap-0 mb-8">
                <button
                  onClick={() => handleFilterChange('all')}
                  className={`px-8 md:px-12 py-3 md:py-3.5 text-sm md:text-base font-semibold transition-all ${filter === 'all'
                    ? 'bg-[#ffd22f] text-[#013064]'
                    : 'bg-[#013064] text-white border border-white hover:bg-white/10'
                    }`}
                >
                  Semua
                </button>
                <button
                  onClick={() => handleFilterChange('live')}
                  className={`px-8 md:px-12 py-3 md:py-3.5 text-sm md:text-base font-semibold transition-all border-l-0 ${filter === 'live'
                    ? 'bg-[#ffd22f] text-[#013064]'
                    : 'bg-[#013064] text-white border border-white hover:bg-white/10'
                    }`}
                >
                  Pertandingan Berlangsung
                </button>
                <button
                  onClick={() => handleFilterChange('upcoming')}
                  className={`px-8 md:px-12 py-3 md:py-3.5 text-sm md:text-base font-semibold transition-all border-l-0 ${filter === 'upcoming'
                    ? 'bg-[#ffd22f] text-[#013064]'
                    : 'bg-[#013064] text-white border border-white hover:bg-white/10'
                    }`}
                >
                  Pertandingan Berikutnya
                </button>
              </div>
            </div>

            {/* Match Cards Grid - Updated Design */}
            {homeMatches && homeMatches.length > 0 ? (
              <div className="grid sm:grid-cols-2 gap-4 md:gap-6">
                {homeMatches.map((match) => (
                  <Link key={match.id} href={`/jadwal-hasil/${match.id}`}>
                    <div className="bg-white py-5 px-5 md:py-6 md:px-6 relative hover:shadow-xl hover:scale-[1.02] transition-all cursor-pointer min-h-[240px] md:min-h-[280px] flex flex-col">
                      <div className="flex items-center justify-center gap-4 md:gap-6 lg:gap-8 flex-1">
                        {/* Team 1 - Logo Only, NO NAME */}
                        <div className="flex flex-col items-center justify-center flex-1">
                          <img
                            src={match.team1.logo}
                            alt={match.team1.name}
                            className="w-16 h-16 md:w-24 md:h-24 lg:w-28 lg:h-28 object-contain"
                            onError={(e) => {
                              e.target.src = '/images/default-team-logo.png';
                            }}
                          />
                        </div>

                        {/* Match Info - Center */}
                        <div className="flex flex-col items-center justify-center min-w-[130px] md:min-w-[150px]">
                          {/* Status Badge - Above League Name */}
                          <div className="mb-1.5">
                            <span className={`px-2.5 py-1 text-xs font-bold uppercase ${match.type === 'live'
                              ? 'bg-red-600 text-white'
                              : match.type === 'upcoming'
                                ? 'bg-green-600 text-white'
                                : 'bg-gray-600 text-white'
                              }`}>
                              {match.type === 'live' ? 'Live' : match.type === 'upcoming' ? 'Upcoming Match' : 'Selesai'}
                            </span>
                          </div>

                          <p className="text-[11px] text-gray-600 mb-1.5 text-center italic">
                            {match.league}
                          </p>
                          <p className="text-sm md:text-base font-bold text-gray-900 text-center">
                            {match.day}
                          </p>
                          <p className="text-sm md:text-base font-bold text-gray-900 text-center mb-1.5">
                            {match.date}
                          </p>
                          <p className="text-[11px] md:text-xs text-gray-600 mb-2.5 tracking-wider">
                            {match.time}
                          </p>
                          {match.score ? (
                            <p className="text-2xl md:text-3xl font-bold text-[#013064]">
                              {match.score}
                            </p>
                          ) : (
                            <p className="text-base md:text-lg font-medium text-gray-400">
                              - vs -
                            </p>
                          )}
                        </div>

                        {/* Team 2 - Logo Only, NO NAME */}
                        <div className="flex flex-col items-center justify-center flex-1">
                          <img
                            src={match.team2.logo}
                            alt={match.team2.name}
                            className="w-16 h-16 md:w-24 md:h-24 lg:w-28 lg:h-28 object-contain"
                            onError={(e) => {
                              e.target.src = '/images/default-team-logo.png';
                            }}
                          />
                        </div>
                      </div>
                    </div>
                  </Link>
                ))}
              </div>
            ) : (
              <div className="text-center py-12">
                <p className="text-white text-xl">Belum ada jadwal pertandingan</p>
              </div>
            )}

            {/* Button Lihat Lebih Banyak */}
            <div className="text-center mt-8">
              <Link href="/jadwal-hasil">
                <button className="bg-[#ffd22f] text-[#013064] px-10 md:px-12 py-3 md:py-3.5 text-sm md:text-base font-bold hover:bg-[#ffe066] transition">
                  Lihat Lebih Banyak
                </button>
              </Link>
            </div>
          </div>
        </div>
        {/* Live Streaming Section - RESPONSIVE */}
        <div className="bg-[#002855] py-12 px-4">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-10 md:mb-12">
              <p className="text-[#ffd22f] text-base md:text-xl lg:text-2xl font-semibold mb-2 md:mb-3">
                Siaran Langsung
              </p>
              <h2 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                Pertandingan Yang Sedang Berlangsung
              </h2>
            </div>

            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
              {liveMatches && liveMatches.length > 0 ? (
                liveMatches.map((game) => (
                  <div
                    key={game.id}
                    onClick={() => game.stream_url && window.open(game.stream_url, '_blank', 'noopener,noreferrer')}
                    className={`group overflow-hidden relative h-[220px] md:h-[240px] lg:h-[260px] rounded-lg transition-all duration-300 ${game.stream_url
                      ? 'cursor-pointer hover:shadow-2xl hover:scale-[1.02]'
                      : 'cursor-not-allowed opacity-75'
                      }`}
                  >
                    <img
                      src={game.img}
                      alt={game.title}
                      className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                      onError={(e) => {
                        e.target.src = '/images/comingsoon.png';
                      }}
                    />

                    {/* Gradient Overlay */}
                    <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />

                    {/* Status Badge */}
                    <span className={`absolute top-3 left-3 ${game.status === "live" ? "bg-red-600 animate-pulse" :
                      game.status === "scheduled" ? "bg-orange-600" :
                        "bg-gray-600"
                      } text-white px-2.5 py-1 text-xs font-semibold z-10 uppercase rounded`}>
                      {game.status === "live" ? "🔴 Live" :
                        game.status === "scheduled" ? "Scheduled" :
                          "✓ Selesai"}
                    </span>

                    {/* Stream Available Indicator */}
                    {game.stream_url && (
                      <div className="absolute top-3 right-3 bg-white/20 backdrop-blur-sm text-white px-2.5 py-1 text-xs font-semibold z-10 rounded flex items-center gap-1">
                        <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                        </svg>
                        Watch
                      </div>
                    )}

                    {/* No Stream Warning */}
                    {!game.stream_url && (
                      <div className="absolute top-3 right-3 bg-red-600/80 backdrop-blur-sm text-white px-2.5 py-1 text-xs font-semibold z-10 rounded">
                        No Stream
                      </div>
                    )}

                    {/* Match Info - Bottom Overlay */}
                    <div className="absolute bottom-0 left-0 right-0 p-4 md:p-5 text-white">
                      <p className="text-[#ffd22f] text-xs font-semibold mb-2">
                        {game.category}
                      </p>
                      <h3 className="text-white text-sm md:text-base font-bold mb-2 leading-tight line-clamp-2">
                        {game.title}
                      </h3>
                      <div className="flex justify-between items-center text-xs mb-2">
                        <span className="text-gray-300">{game.venue}</span>
                        <span className="text-white font-bold">{game.time}</span>
                      </div>
                      <p className="text-gray-400 text-xs">{game.court}</p>
                    </div>

                    {/* Hover Overlay untuk yang ada stream */}
                    {game.stream_url && (
                      <div className="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div className="bg-[#ffd22f] text-[#013064] px-6 py-3 rounded-lg font-bold text-sm flex items-center gap-2">
                          <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                          </svg>
                          Tonton Sekarang
                        </div>
                      </div>
                    )}
                  </div>
                ))
              ) : (
                <div className="col-span-full flex justify-center items-center py-12">
                  <div className="w-full max-w-2xl">
                    <img
                      src="/images/comingsoon.png"
                      alt="Coming Soon"
                      className="w-full h-auto"
                    />
                  </div>
                </div>
              )}
            </div>

            <div className="text-center">
              <Link href="/siaran-langsung">
                <button className="bg-[#ffd22f] text-[#013064] px-8 md:px-10 py-2.5 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition">
                  Lihat Lebih Banyak
                </button>
              </Link>
            </div>
          </div>
        </div>
        {/* Sponsor and Partners Section - RESPONSIVE */}
<div className="bg-[#013064] py-12 md:py-16 lg:py-20 px-4">
  <div className="max-w-7xl mx-auto">
    <div className="text-center mb-12 md:mb-16">
      <h2 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold">
        Partner dan Sponsor Kami
      </h2>
    </div>

    {/* Presented By Section (Sponsors) */}
    {sponsors && sponsors.length > 0 && (
      <div className="mb-16 md:mb-20">
        <p className="text-[#ffd22f] text-center text-lg md:text-xl lg:text-2xl font-semibold mb-6 md:mb-8">
          Presented By
        </p>
        <div className="flex flex-col sm:flex-row justify-center gap-6 md:gap-8 flex-wrap">
          {sponsors.map((sponsor) => (
            <div 
              key={sponsor.id} 
              className="bg-white p-8 md:p-12 flex items-center justify-center w-full sm:w-96 md:w-[440px] h-96 md:h-[440px] rounded-lg shadow-lg"
            >
              <img 
                src={sponsor.image} 
                alt={sponsor.name} 
                className="max-w-full max-h-full object-contain" 
              />
            </div>
          ))}
        </div>
      </div>
    )}

    {/* Official Partner Section */}
    {partners && partners.length > 0 && (
      <div className="mb-16 md:mb-20">
        <p className="text-[#ffd22f] text-center text-lg md:text-xl lg:text-2xl font-semibold mb-6 md:mb-8">
          Official Partner
        </p>
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4 lg:gap-6">
          {partners.map((partner) => (
            <div 
              key={partner.id} 
              className="bg-white p-3 md:p-4 lg:p-6 flex items-center justify-center w-full h-32 md:h-40 lg:h-48 hover:scale-105 transition-transform rounded-lg shadow-md"
            >
              <img 
                src={partner.image} 
                alt={partner.name} 
                className="max-w-full max-h-full object-contain" 
              />
            </div>
          ))}
        </div>
      </div>
    )}
  </div>
</div>

        {/* Contact Section - RESPONSIVE */}
        <Contact />


        {/* Footer Section - RESPONSIVE */}
        <Footer />

        {/* Copyright Bar */}

      </div>
    </>
  );
}

