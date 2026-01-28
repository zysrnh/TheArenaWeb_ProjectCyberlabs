import { Head, Link, usePage } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { ChevronDown } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import Contact from '../../Components/Contact';

export default function LivePage() {
  const { auth, liveMatches: initialMatches } = usePage().props;
  const [selectedTime, setSelectedTime] = useState("all");
  const [selectedSeries, setSelectedSeries] = useState("all");
  const [searchQuery, setSearchQuery] = useState("");
  const [matches, setMatches] = useState(initialMatches || []);
  const [isLoading, setIsLoading] = useState(false);

  // Fetch matches dengan filter
  const fetchMatches = async () => {
    setIsLoading(true);
    try {
      const params = new URLSearchParams({
        time: selectedTime,
        series: selectedSeries
      });
      
      const response = await fetch(`/api/live/filter?${params}`);
      const data = await response.json();
      setMatches(data.matches);
    } catch (error) {
      console.error('Error fetching matches:', error);
    } finally {
      setIsLoading(false);
    }
  };

  // Debounce search
  useEffect(() => {
    const delaySearch = setTimeout(async () => {
      if (searchQuery.trim()) {
        setIsLoading(true);
        try {
          const response = await fetch(`/api/live/search?query=${encodeURIComponent(searchQuery)}`);
          const data = await response.json();
          setMatches(data.matches);
        } catch (error) {
          console.error('Error searching matches:', error);
        } finally {
          setIsLoading(false);
        }
      } else {
        fetchMatches();
      }
    }, 500);

    return () => clearTimeout(delaySearch);
  }, [searchQuery]);

  // Trigger fetch saat filter berubah
  useEffect(() => {
    if (!searchQuery.trim()) {
      fetchMatches();
    }
  }, [selectedTime, selectedSeries]);

  // Handle click card
  const handleCardClick = (streamUrl) => {
    if (streamUrl) {
      window.open(streamUrl, '_blank', 'noopener,noreferrer');
    }
  };

  return (
    <>
      <Head title="THE ARENA - Live" />
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
        <Navigation activePage="siaran-langsung" />

        {/* Hero Section */}
        <div className="bg-[#013064] py-12 md:py-16 px-4">
          <div className="max-w-7xl mx-auto">
            <div className="mb-8">
              <p className="text-[#ffd22f] text-3xl md:text-4xl mb-3">
                Pertandingan
              </p>
              <h1 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold">
                Tonton Pertandingan<br />Secara Live!
              </h1>
            </div>

            {/* Filter Dropdowns & Search Row */}
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
              <div className="flex flex-wrap gap-2">
                {/* Time Filter */}
                <div className="relative">
                  <select 
                    value={selectedTime}
                    onChange={(e) => setSelectedTime(e.target.value)}
                    className="bg-[#ffd22f] text-[#013064] px-6 py-2.5 text-sm md:text-base font-semibold cursor-pointer appearance-none pr-10 rounded"
                  >
                    <option value="all">Filter Waktu</option>
                    <option value="morning">Pagi (08:00 - 12:00)</option>
                    <option value="afternoon">Siang (12:00 - 16:00)</option>
                    <option value="evening">Sore (16:00 - 20:00)</option>
                    <option value="night">Malam (20:00 - 00:00)</option>
                  </select>
                  <ChevronDown className="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#013064] pointer-events-none" />
                </div>

                {/* Series Filter */}
                <div className="relative">
                  <select 
                    value={selectedSeries}
                    onChange={(e) => setSelectedSeries(e.target.value)}
                    className="bg-[#ffd22f] text-[#013064] px-6 py-2.5 text-sm md:text-base font-semibold cursor-pointer appearance-none pr-10 rounded"
                  >
                    <option value="all">Semua Series</option>
                    <option value="regular">Regular Season</option>
                    <option value="playoff">Playoff</option>
                    <option value="final">Final</option>
                  </select>
                  <ChevronDown className="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#013064] pointer-events-none" />
                </div>
              </div>

              {/* Search Box */}
              <div className="w-full md:w-auto md:min-w-[400px]">
                <div className="relative">
                  <input
                    type="text"
                    placeholder="Cari Pertandingan"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="w-full px-6 py-2.5 pr-12 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#ffd22f] rounded"
                  />
                  <button className="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg className="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Live Matches Grid */}
        <div className="bg-[#013064] py-12 px-4">
          <div className="max-w-7xl mx-auto">
            {isLoading ? (
              <div className="flex justify-center items-center py-20">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#ffd22f]"></div>
              </div>
            ) : matches.length === 0 ? (
              <div className="flex justify-center items-center py-12">
                <div className="w-full max-w-4xl">
                  <img 
                    src="/images/comingsoon.png" 
                    alt="Coming Soon" 
                    className="w-full h-auto"
                  />
                </div>
              </div>
            ) : (
              <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
                {matches.map((game) => (
                  <div 
                    key={game.id} 
                    onClick={() => handleCardClick(game.stream_url)}
                    className={`group overflow-hidden relative h-[220px] md:h-[240px] lg:h-[260px] rounded-lg transition-all duration-300 ${
                      game.stream_url 
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

                    <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />

                    {/* Status Badge */}
                    <span className={`absolute top-3 left-3 ${
                      game.status === "live" ? "bg-red-600 animate-pulse" : 
                      game.status === "scheduled" ? "bg-orange-600" : 
                      "bg-gray-600"
                    } text-white px-2.5 py-1 text-xs font-semibold z-10 uppercase rounded`}>
                      {game.status === "live" ? "🔴 Live" : 
                       game.status === "scheduled" ? "Scheduled" : 
                       "✓ Ended"}
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

                    {/* Match Info */}
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
                ))}
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