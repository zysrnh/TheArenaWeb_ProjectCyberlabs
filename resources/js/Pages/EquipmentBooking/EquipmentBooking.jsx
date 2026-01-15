import { Head, Link, usePage, router } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { Search, ChevronRight } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import Contact from '../../Components/Contact';

export default function EquipmentBooking() {
  const { auth, equipments: initialEquipments, categories: initialCategories } = usePage().props;
  const [equipments, setEquipments] = useState(initialEquipments);
  const [categories, setCategories] = useState(initialCategories || []);
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("Semua");

  // Filter equipments based on search and category
  useEffect(() => {
    fetchEquipments();
  }, [searchQuery, selectedCategory]);

  const fetchEquipments = async () => {
    try {
      const response = await fetch(
        `/api/equipment-booking/equipments?search=${searchQuery}&category=${selectedCategory}`
      );
      const data = await response.json();
      if (data.success) {
        setEquipments(data.equipments);
      }
    } catch (error) {
      console.error("Error fetching equipments:", error);
    }
  };

  const handleSearchChange = (e) => {
    setSearchQuery(e.target.value);
  };

  const handleCategoryClick = (category) => {
    setSelectedCategory(category);
  };

  const truncateDescription = (text, maxLength = 50) => {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
  };

  return (
    <>
      <Head title="THE ARENA - Booking Peralatan" />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
                @keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
}

@keyframes pulse-ring {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  100% {
    transform: scale(1.5);
    opacity: 0;
  }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-pulse-ring {
  animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

      `}</style>
      <div className="min-h-screen flex flex-col bg-[#013064]">
        <Navigation activePage="equipment" />

        {/* Main Content */}
        <div className="flex-1 bg-[#013064]">
          <div className="max-w-7xl mx-auto px-4 py-8 md:py-12">
            {/* Header Section */}
            <div className="mb-8">
              <p className="text-[#ffd22f] text-base md:text-lg lg:text-xl font-semibold mb-2">
                Peralatan
              </p>
              <h2 className="text-white text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-6 md:mb-8">
                Sewa Peralatan Basket
              </h2>

              {/* Category Filter Tabs & Search Bar - Desktop */}
              <div className="hidden lg:flex items-center justify-between gap-6 mb-6">
                {/* Category Tabs */}
                <div className="flex gap-3 overflow-x-auto">
                  <button
                    onClick={() => handleCategoryClick("Semua")}
                    className={`px-6 py-2.5 font-semibold text-base transition whitespace-nowrap ${
                      selectedCategory === "Semua"
                        ? "bg-[#ffd22f] text-[#013064]"
                        : "bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]"
                    }`}
                  >
                    Semua
                  </button>
                  {categories.map((category) => (
                    <button
                      key={category}
                      onClick={() => handleCategoryClick(category)}
                      className={`px-6 py-2.5 font-semibold text-base transition whitespace-nowrap ${
                        selectedCategory === category
                          ? "bg-[#ffd22f] text-[#013064]"
                          : "bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]"
                      }`}
                    >
                      {category}
                    </button>
                  ))}
                </div>

                {/* Search Bar */}
                <div className="relative w-96 flex-shrink-0">
                  <input
                    type="text"
                    placeholder="Cari peralatan..."
                    value={searchQuery}
                    onChange={handleSearchChange}
                    className="w-full pl-4 pr-12 py-2.5 bg-white text-[#013064] outline-none text-base"
                  />
                  <button className="absolute right-0 top-0 h-full px-4 bg-white hover:bg-gray-100">
                    <Search className="w-5 h-5 text-[#013064]" />
                  </button>
                </div>
              </div>

              {/* Category Filter Tabs & Search Bar - Mobile/Tablet */}
              <div className="lg:hidden space-y-4 mb-6">
                {/* Category Tabs */}
                <div className="overflow-x-auto">
                  <div className="flex gap-3 pb-2 min-w-max">
                    <button
                      onClick={() => handleCategoryClick("Semua")}
                      className={`px-6 py-2.5 font-semibold text-sm md:text-base transition whitespace-nowrap ${
                        selectedCategory === "Semua"
                          ? "bg-[#ffd22f] text-[#013064]"
                          : "bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]"
                      }`}
                    >
                      Semua
                    </button>
                    {categories.map((category) => (
                      <button
                        key={category}
                        onClick={() => handleCategoryClick(category)}
                        className={`px-6 py-2.5 font-semibold text-sm md:text-base transition whitespace-nowrap ${
                          selectedCategory === category
                            ? "bg-[#ffd22f] text-[#013064]"
                            : "bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]"
                        }`}
                      >
                        {category}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Search Bar */}
                <div className="relative w-full">
                  <input
                    type="text"
                    placeholder="Cari peralatan..."
                    value={searchQuery}
                    onChange={handleSearchChange}
                    className="w-full pl-4 pr-12 py-2.5 bg-white text-[#013064] outline-none text-sm md:text-base"
                  />
                  <button className="absolute right-0 top-0 h-full px-4 bg-white hover:bg-gray-100">
                    <Search className="w-5 h-5 text-[#013064]" />
                  </button>
                </div>
              </div>
            </div>

            {/* Equipment List - Responsive Layout */}
            <div className="space-y-6 md:space-y-8">
              {equipments.map((equipment) => (
                <div
                  key={equipment.id}
                  className="bg-[#013064] overflow-hidden flex flex-col md:grid md:grid-cols-[300px_1fr] lg:grid-cols-[400px_1fr] xl:grid-cols-[500px_1fr]"
                >
                  {/* Image Section */}
                  <div className="relative w-full h-[250px] md:h-[300px] lg:h-[350px] xl:h-[400px]">
                    <img
                      src={equipment.image || "https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800"}
                      alt={equipment.name}
                      className="w-full h-full object-cover object-center"
                    />
                    {/* Category Badge */}
                    {equipment.category && (
                      <div className="absolute top-4 left-4 bg-[#ffd22f] text-[#013064] px-4 py-1.5 text-sm font-semibold">
                        {equipment.category}
                      </div>
                    )}
                  </div>

                  {/* Content Section */}
                  <div className="bg-[#013064] text-white p-6 md:p-6 lg:p-10 xl:p-12 flex flex-col justify-center">
                    <h3 className="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-4 md:mb-6">
                      {equipment.name}
                    </h3>
                    <p className="text-gray-300 text-sm md:text-base mb-4 md:mb-6 leading-relaxed break-words whitespace-normal" style={{ maxWidth: '40ch' }}>
                      {truncateDescription(equipment.description, 50)}
                    </p>
                    <Link
                      href={`/booking-peralatan/${equipment.id}`}
                      className="bg-[#ffd22f] text-[#013064] px-6 md:px-8 py-2.5 md:py-3 text-sm md:text-base font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit"
                    >
                      Lihat Lebih Lengkap
                      <ChevronRight className="w-5 h-5" />
                    </Link>
                  </div>
                </div>
              ))}
            </div>

            {equipments.length === 0 && (
              <div className="text-center py-12">
                <p className="text-white text-base md:text-lg">
                  {searchQuery || selectedCategory !== "Semua" 
                    ? "Tidak ada peralatan yang sesuai dengan pencarian atau kategori"
                    : "Tidak ada peralatan yang tersedia"}
                </p>
              </div>
            )}
          </div>
        </div>

        <Contact />
        <Footer />
        <a
  href="https://wa.me/6281222977985"
  target="_blank"
  rel="noopener noreferrer"
  className="fixed bottom-6 right-6 z-50 group"
  aria-label="Chat WhatsApp"
>
  {/* Pulse Ring Effect */}
  <div className="absolute inset-0 bg-[#25D366] rounded-full animate-pulse-ring"></div>
  
  {/* Main Button */}
  <div className="relative bg-[#25D366] hover:bg-[#20BA5A] w-14 h-14 md:w-16 md:h-16 rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 hover:scale-110 animate-float">
    <img
      src="/images/whatsapp-symbol-logo-svgrepo-com.svg"
      alt="WhatsApp"
      className="w-8 h-8 md:w-9 md:h-9"
    />
  </div>
  
  {/* Tooltip */}
  <div className="absolute right-full mr-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
    <div className="bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-xl">
      Chat dengan Kami
      <div className="absolute right-0 top-1/2 -translate-y-1/2 translate-x-full">
        <div className="border-8 border-transparent border-l-gray-900"></div>
      </div>
    </div>
  </div>
</a>
      </div>
    </>
  );
}