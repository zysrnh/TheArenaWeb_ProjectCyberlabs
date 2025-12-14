import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";
import { ChevronRight, Search } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import Contact from "../../Components/Contact";

export default function News({ auth, news, latestNews, popularNews, currentPage, totalPages, filter, search }) {
  const [searchQuery, setSearchQuery] = useState(search || "");
  const [activeFilter, setActiveFilter] = useState(filter || "all");

  const handleFilterChange = (newFilter) => {
    setActiveFilter(newFilter);
    router.get('/berita', { filter: newFilter, search: searchQuery }, {
      preserveState: true,
      preserveScroll: true
    });
  };

  const handleSearch = (e) => {
    e.preventDefault();
    router.get('/berita', { filter: activeFilter, search: searchQuery }, {
      preserveState: true,
      preserveScroll: true
    });
  };

  const handlePageChange = (page) => {
    router.get('/berita', { filter: activeFilter, search: searchQuery, page }, {
      preserveState: true,
      preserveScroll: false
    });
  };

  return (
    <>
      <Head title="THE ARENA - Berita" />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
      `}</style>
      <div className="min-h-screen flex flex-col bg-[#013064]">
        {/* Navigation */}
        <Navigation activePage="news" />

        {/* Hero Section - Simple */}
        <main className="flex-1">
          <div className="bg-[#013064] pt-12 pb-8 px-4">
            <div className="max-w-7xl mx-auto">
              <p className="text-[#ffd22f] text-xl md:text-2xl font-semibold mb-3">
                Berita
              </p>
              <h1 className="text-white text-4xl md:text-5xl font-bold mb-8">
                Berita Seputar Pertandingan Basket
              </h1>

              {/* Filter & Search Section */}
              <div className="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                {/* Filter Tabs */}
                <div className="flex flex-wrap gap-3">
                  <button
                    onClick={() => handleFilterChange('all')}
                    className={`px-6 py-2 text-sm font-semibold transition ${
                      activeFilter === 'all'
                        ? 'bg-[#ffd22f] text-[#013064]'
                        : 'bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]'
                    }`}
                  >
                    Semua
                  </button>
                  <button
                    onClick={() => handleFilterChange('latest')}
                    className={`px-6 py-2 text-sm font-semibold transition ${
                      activeFilter === 'latest'
                        ? 'bg-[#ffd22f] text-[#013064]'
                        : 'bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]'
                    }`}
                  >
                    Terbaru
                  </button>
                  <button
                    onClick={() => handleFilterChange('popular')}
                    className={`px-6 py-2 text-sm font-semibold transition ${
                      activeFilter === 'popular'
                        ? 'bg-[#ffd22f] text-[#013064]'
                        : 'bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]'
                    }`}
                  >
                    Populer
                  </button>
                </div>

                {/* Search Bar */}
                <form onSubmit={handleSearch} className="w-full lg:w-auto">
                  <div className="relative">
                    <input
                      type="text"
                      value={searchQuery}
                      onChange={(e) => setSearchQuery(e.target.value)}
                      placeholder="Cari Berita"
                      className="w-full lg:w-96 px-4 py-2.5 pr-12 bg-white text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#ffd22f]"
                    />
                    <button
                      type="submit"
                      className="absolute right-0 top-0 h-full px-4 bg-transparent hover:bg-gray-100 transition flex items-center justify-center"
                    >
                      <Search className="w-5 h-5 text-gray-600" />
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          {/* Content Section */}
          <div className="bg-[#013064] py-12 px-4">
            <div className="max-w-7xl mx-auto">
              <div className="grid lg:grid-cols-3 gap-8">
                {/* Main Content - Vertical News List */}
                <div className="lg:col-span-2">
                  {news && news.length > 0 ? (
                    <>
                      <div className="space-y-8 mb-12">
                        {news.map((item) => (
                          <div key={item.id} className="flex flex-col md:flex-row gap-4 md:gap-6 group cursor-pointer">
                            {/* Image - Besar seperti semula */}
                            <Link href={`/berita/${item.id}`} className="flex-shrink-0 w-full md:w-96 h-64 md:h-64 overflow-hidden relative">
                              <img
                                src={item.image}
                                alt={item.title}
                                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                              />
                              <span className="absolute top-3 left-3 bg-[#e74c3c] text-white px-3 py-1 text-xs font-semibold">
                                News
                              </span>
                            </Link>

                            {/* Content */}
                            <div className="flex-1 flex flex-col justify-center">
                              <p className="text-gray-300 text-xs mb-2">
                                News - {item.date}
                              </p>
                              <Link href={`/berita/${item.id}`}>
                                <h3 className="text-white text-xl md:text-2xl font-bold mb-3 leading-tight group-hover:text-[#ffd22f] transition line-clamp-2">
                                  {item.title}
                                </h3>
                              </Link>
                              <p className="text-gray-300 text-sm mb-4 leading-relaxed line-clamp-3">
                                {item.excerpt}
                              </p>
                              <Link href={`/berita/${item.id}`}>
                                <button className="bg-[#ffd22f] text-[#013064] px-6 py-2.5 text-sm font-semibold hover:bg-[#ffe066] transition inline-flex items-center gap-2 w-fit">
                                  Lihat Lebih Lengkap
                                  <ChevronRight className="w-4 h-4" />
                                </button>
                              </Link>
                            </div>
                          </div>
                        ))}
                      </div>

                      {/* Pagination */}
                      {totalPages > 1 && (
                        <div className="flex justify-center gap-2 mt-8">
                          {[...Array(totalPages)].map((_, idx) => (
                            <button
                              key={idx + 1}
                              onClick={() => handlePageChange(idx + 1)}
                              className={`w-10 h-10 flex items-center justify-center text-sm font-semibold transition ${
                                currentPage === idx + 1
                                  ? 'bg-[#ffd22f] text-[#013064]'
                                  : 'bg-transparent text-white border-2 border-white hover:bg-white hover:text-[#013064]'
                              }`}
                            >
                              {idx + 1}
                            </button>
                          ))}
                        </div>
                      )}
                    </>
                  ) : (
                    <div className="text-center py-12">
                      <p className="text-white text-lg">Tidak ada berita ditemukan</p>
                    </div>
                  )}
                </div>

                {/* Sidebar */}
                <div className="lg:col-span-1">
                  {/* Berita Terbaru */}
                  <div className="mb-12">
                    <h3 className="text-white text-lg font-bold mb-6">
                      Berita Terbaru
                    </h3>
                    <div className="space-y-8">
                      {latestNews.map((item, index) => (
                        <Link key={item.id} href={`/berita/${item.id}`}>
                          <div className="group cursor-pointer">
                            {/* First item with image - 280x158px */}
                            {index === 0 && (
                              <div className="relative w-full max-w-[280px] h-[158px] overflow-hidden mb-4">
                                <img
                                  src={item.image}
                                  alt={item.title}
                                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                                <span className="absolute top-1.5 left-1.5 bg-[#e74c3c] text-white px-1.5 py-0.5 text-[9px] font-semibold">
                                  News
                                </span>
                              </div>
                            )}
                            
                            {/* Content */}
                            <p className="text-gray-400 text-[9px] mb-2">
                              News - {item.date}
                            </p>
                            <h4 className="text-white text-xs font-bold leading-tight line-clamp-2 group-hover:text-[#ffd22f] transition mb-3">
                              {item.title}
                            </h4>
                            <p className="text-gray-300 text-[10px] leading-relaxed line-clamp-2">
                              {item.excerpt}
                            </p>
                          </div>
                        </Link>
                      ))}
                    </div>
                  </div>

                  {/* Berita Populer */}
                  <div>
                    <h3 className="text-white text-lg font-bold mb-6">
                      Berita Populer
                    </h3>
                    <div className="space-y-8">
                      {popularNews.map((item, index) => (
                        <Link key={item.id} href={`/berita/${item.id}`}>
                          <div className="group cursor-pointer">
                            {/* First item with image - 280x158px */}
                            {index === 0 && (
                              <div className="relative w-full max-w-[280px] h-[158px] overflow-hidden mb-4">
                                <img
                                  src={item.image}
                                  alt={item.title}
                                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                                <span className="absolute top-1.5 left-1.5 bg-[#e74c3c] text-white px-1.5 py-0.5 text-[9px] font-semibold">
                                  News
                                </span>
                              </div>
                            )}
                            
                            {/* Content */}
                            <p className="text-gray-400 text-[9px] mb-2">
                              News - {item.date}
                            </p>
                            <h4 className="text-white text-xs font-bold leading-tight line-clamp-2 group-hover:text-[#ffd22f] transition mb-3">
                              {item.title}
                            </h4>
                            <p className="text-gray-300 text-[10px] leading-relaxed line-clamp-2">
                              {item.excerpt}
                            </p>
                          </div>
                        </Link>
                      ))}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>

        {/* Contact Section */}
        <Contact />

        {/* Footer */}
        <Footer />
      </div>
    </>
  );
}