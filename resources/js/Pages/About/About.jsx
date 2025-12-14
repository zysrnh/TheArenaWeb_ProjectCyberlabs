import { Head, Link, usePage, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { Phone, Mail } from "lucide-react";
import Footer from "../../Components/Footer";
import Navigation from "../../Components/Navigation";
export default function About() {
  const { auth } = usePage().props;
  const [isScrolled, setIsScrolled] = useState(false);
  const [lastScrollY, setLastScrollY] = useState(0);
  const [showContactBar, setShowContactBar] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      const currentScrollY = window.scrollY;
      
      setIsScrolled(currentScrollY > 50);
      
      // Show contact bar when scrolling down, hide when scrolling up
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

  const handleLogout = () => {
    if (confirm('Apakah Anda yakin ingin keluar?')) {
      router.post('/logout');
    }
  };

  return (
    <>
      <Head title="THE ARENA - About" />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
      `}</style>
      <div className="min-h-screen flex flex-col bg-white">
        {/* Navigation - RESPONSIVE & STICKY */}
        <Navigation activePage="tentang" />
        {/* Hero Title Section */}
        <div className="bg-[#013064] py-12 md:py-16 lg:py-20 px-4 md:px-8 lg:px-16">
          <div className="max-w-7xl mx-auto">
            <p className="text-[#ffd22f] text-lg md:text-xl lg:text-2xl font-semibold mb-3 md:mb-4">
              Tentang
            </p>
            <h1 className="text-white text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight">
              The Arena History
            </h1>
          </div>
        </div>

        {/* Main Content Section */}
        <div className="flex-1">
          <div className="grid md:grid-cols-2">
            {/* Left Section - Image */}
            <div className="relative h-[350px] md:h-[400px] lg:h-[450px]">
              <img
                src="https://images.unsplash.com/photo-1504450874802-0ba2bcd9b5ae?w=1200"
                alt="The Arena Basketball Court"
                className="w-full h-full object-cover"
              />
            </div>

            {/* Right Section - Content Description */}
            <div className="bg-[#003f84] text-white p-6 md:p-10 lg:p-14 flex flex-col justify-center">
              <h2 className="text-white text-2xl md:text-3xl lg:text-4xl font-bold mb-4 md:mb-6 leading-tight">
                The Arena
              </h2>
              
              <div className="space-y-3 md:space-y-4 text-gray-200 text-xs md:text-sm lg:text-base leading-relaxed">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                  eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                  ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                  aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet,
                  consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                  nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat.
                </p>
                
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                  eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                  ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                  aliquip ex ea commodo consequat.
                </p>
              </div>
            </div>
          </div>
        </div>

        {/* Komunitas Section */}
        <div className="grid md:grid-cols-2">
          {/* Left Section - Content Description */}
          <div className="bg-[#003f84] text-white p-6 md:p-10 lg:p-14 flex flex-col justify-center order-2 md:order-1">
            <h2 className="text-white text-2xl md:text-3xl lg:text-4xl font-bold mb-4 md:mb-6 leading-tight">
              Komunitas
            </h2>
            
            <div className="space-y-3 md:space-y-4 text-gray-200 text-xs md:text-sm lg:text-base leading-relaxed">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet,
                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
              </p>
              
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat.
              </p>
            </div>
          </div>

          {/* Right Section - Image */}
          <div className="relative h-[350px] md:h-[400px] lg:h-[450px] order-1 md:order-2">
            <img
              src="https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1200"
              alt="Basketball Community"
              className="w-full h-full object-cover"
            />
          </div>
        </div>

        {/* Fasilitas Section - Grid 3 Kolom */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          {/* Fasilitas 1 - Cafe & Resto */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800"
              alt="Cafe & Resto"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Cafe & Resto
              </h3>
            </div>
          </div>

          {/* Fasilitas 2 - Jual Makanan Ringan */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=800"
              alt="Jual Makanan Ringan"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Jual Makanan Ringan
              </h3>
            </div>
          </div>

          {/* Fasilitas 3 - Jual Minuman */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1534353436294-0dbd4bdac845?w=800"
              alt="Jual Minuman"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Jual Minuman
              </h3>
            </div>
          </div>

          {/* Fasilitas 4 - Parkir Motor */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1558981852-426c6c22a060?w=800"
              alt="Parkir Motor"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Parkir Motor
              </h3>
            </div>
          </div>

          {/* Fasilitas 5 - Parkir Mobil */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800"
              alt="Parkir Mobil"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Parkir Mobil
              </h3>
            </div>
          </div>

          {/* Fasilitas 6 - Toilet */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800"
              alt="Toilet"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Toilet
              </h3>
            </div>
          </div>
        </div>

        {/* Tribun Penonton Section - 3 Columns Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3">
          {/* Left - Image Card (1 column) */}
          <div className="group cursor-pointer overflow-hidden relative h-[280px] md:h-[320px] lg:h-[350px]">
            <img
              src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200"
              alt="Tribun Penonton"
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
            <div className="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
              <span className="text-[#ffd22f] text-sm md:text-base font-semibold mb-1 md:mb-2 block">
                Fasilitas
              </span>
              <h3 className="text-xl md:text-2xl lg:text-3xl font-bold">
                Tribun Penonton
              </h3>
            </div>
          </div>

          {/* Right - Text Content (2 columns) */}
          <div className="md:col-span-2 bg-[#003f84] text-white p-4 md:p-6 lg:p-8 flex flex-col justify-center h-[280px] md:h-[320px] lg:h-[350px]">
            <div className="space-y-3 md:space-y-4 text-gray-200 text-xs md:text-sm leading-relaxed">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                officia deserunt mollit anim id est laborum.
              </p>
              
              <p>
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          </div>
        </div>

        {/* Full Width Description Section */}
        <div className="bg-[#003f84] text-white py-8 md:py-12 lg:py-16 px-6 md:px-12 lg:px-20">
          <div className="max-w-7xl mx-auto">
            <div className="space-y-4 md:space-y-6 text-gray-200 text-xs md:text-sm lg:text-base leading-relaxed">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              </p>
            </div>
          </div>
        </div>

        <Footer />

      </div>
    </>
  );
}