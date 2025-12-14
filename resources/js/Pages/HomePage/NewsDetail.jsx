import { Head, Link, router } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import Contact from "../../Components/Contact";

export default function NewsDetail({ auth, news, latestNews, popularNews }) {
  return (
    <>
      <Head title={`THE ARENA - ${news.title}`} />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
      `}</style>
      <div className="min-h-screen flex flex-col bg-[#013064]">
        {/* Navigation */}
        <Navigation activePage="news" />

        {/* News Hero Section */}
        <main className="flex-1">
          <div className="relative h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden">
            <div
              className="absolute inset-0 bg-cover bg-center"
              style={{
                backgroundImage: `url('${news.image}')`,
                filter: "brightness(0.4)",
              }}
            />

            <div className="relative z-10 h-full flex items-end">
              <div className="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 w-full pb-8 md:pb-12">
                <Link href="/berita">
                  <button className="mb-6 flex items-center gap-2 text-white hover:text-[#ffd22f] transition">
                    <div className="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                      <ChevronLeft className="w-5 h-5 text-[#013064]" />
                    </div>
                  </button>
                </Link>
                <h1 className="text-2xl md:text-4xl lg:text-5xl font-bold text-white leading-tight max-w-4xl">
                  {news.title}
                </h1>
              </div>
            </div>
          </div>

          {/* Content Section */}
          <div className="bg-[#013064] py-12 md:py-16 px-4">
            <div className="max-w-7xl mx-auto">
              <div className="grid lg:grid-cols-3 gap-8 lg:gap-12">
                {/* Main Content */}
                <div className="lg:col-span-2">
                  <div className="bg-[#002855] p-6 md:p-8 lg:p-10 rounded-lg">
                    <p className="text-gray-300 text-sm mb-6 italic">
                      {news.date}
                    </p>

                    <div className="prose prose-invert max-w-none">
                      {news.content.split('\n\n').map((paragraph, idx) => (
                        <p key={idx} className="text-gray-300 text-sm md:text-base mb-4 leading-relaxed">
                          {paragraph}
                        </p>
                      ))}
                    </div>
                  </div>
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