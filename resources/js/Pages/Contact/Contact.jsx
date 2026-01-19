import { Head, Link, useForm, usePage, router } from "@inertiajs/react";
import { Phone, Mail, MapPin, Clock, CheckCircle, AlertCircle, X } from "lucide-react";
import Navigation from "../../Components/Navigation";
import Footer from "../../Components/Footer";
import { useEffect, useState } from "react";

export default function Contact() {
  const { auth, flash, activeEventNotif = null } = usePage().props;
  const [showSuccess, setShowSuccess] = useState(false);
  const [showAuthWarning, setShowAuthWarning] = useState(false);
  const [showEventNotifPopup, setShowEventNotifPopup] = useState(false);

  const { data, setData, post, processing, errors, reset } = useForm({
    nama: '',
    email: '',
    subject: '',
    pesan: '',
  });

  // ✅ SHOW EVENT NOTIF POPUP
  useEffect(() => {
    if (activeEventNotif) {
      setShowEventNotifPopup(true);
    }
  }, [activeEventNotif]);

  useEffect(() => {
    if (flash?.success) {
      setShowSuccess(true);
      const timer = setTimeout(() => {
        setShowSuccess(false);
      }, 5000);
      return () => clearTimeout(timer);
    }
  }, [flash]);

  const handleSubmit = (e) => {
    e.preventDefault();

    // Check if user is logged in
    if (!auth?.client) {
      setShowAuthWarning(true);
      setTimeout(() => {
        setShowAuthWarning(false);
      }, 5000);
      return;
    }

    post(route('contact.submit'), {
      onSuccess: () => {
        reset();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      },
    });
  };

  const handleLoginRedirect = () => {
    router.visit('/login');
  };

  const handleCloseEventNotifPopup = () => {
    setShowEventNotifPopup(false);
  };

  const handleRegisterEvent = () => {
    if (activeEventNotif?.whatsapp_url) {
      window.open(activeEventNotif.whatsapp_url, '_blank', 'noopener,noreferrer');
      handleCloseEventNotifPopup();
    }
  };

  return (
    <>
      <Head title="THE ARENA - Contact" />
      <style>{`
        @keyframes fade-in {
          from { opacity: 0; }
          to { opacity: 1; }
        }

        @keyframes modal-appear {
          from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
          }
          to {
            opacity: 1;
            transform: translateY(0) scale(1);
          }
        }

        .animate-fade-in {
          animation: fade-in 0.3s ease-out;
        }

        .animate-modal-appear {
          animation: modal-appear 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

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
        {/* Navigation Component */}
        <Navigation activePage="kontak" />

        {/* Hero Section */}
        <div className="bg-[#013064] py-12 md:py-16 px-4">
          <div className="max-w-7xl mx-auto">
            <p className="text-[#ffd22f] text-base md:text-lg font-medium mb-2">
              Kontak
            </p>
            <h1 className="text-white text-3xl md:text-4xl lg:text-5xl font-bold">
              Hubungi Kami
            </h1>
          </div>
        </div>

        {/* Contact Info & Map Section */}
        <div className="bg-[#013064] py-8 md:py-12 px-4">
          <div className="max-w-7xl mx-auto">
            <div className="grid md:grid-cols-2 gap-8 md:gap-12 items-start">
              {/* Left: Contact Information */}
              <div className="text-white space-y-6">
                <div className="flex items-start gap-4">
                  <a
                    href="https://wa.me/6281222977985"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="flex items-start gap-4"
                  >
                    <div className="bg-[#ffd22f] rounded-full p-3 flex-shrink-0">
                      <Phone className="w-5 h-5 text-[#013064]" />
                    </div>
                    <div>
                      <p className="text-white text-base">+6812-2297-7985</p>
                    </div>
                  </a>
                </div>

                <div className="flex items-start gap-4">
                  <a
                    href="mailto:arena.basketball.id@gmail.com"
                    className="flex items-start gap-4"
                  >
                    <div className="bg-[#ffd22f] rounded-full p-3 flex-shrink-0">
                      <Mail className="w-5 h-5 text-[#013064]" />
                    </div>
                    <div>
                      <p className="text-white text-base">arena.basketball.id@gmail.com</p>
                    </div>
                  </a>
                </div>
                <div className="flex items-start gap-4">
                  <a
                    href="https://maps.google.com/?q=The+Arena+Urban+Bandung"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="flex items-start gap-4"
                  >
                    <div className="bg-[#ffd22f] rounded-full p-3 flex-shrink-0">
                      <MapPin className="w-5 h-5 text-[#013064]" />
                    </div>
                    <div>
                      <p className="text-white text-base">
                        The Arena Urban – Jl. Kelenteng No. 41, Ciroyom, Andir, Kota Bandung
                      </p>
                    </div>
                  </a>
                </div>

                <div className="flex items-start gap-4">
                  <div className="bg-[#ffd22f] rounded-full p-3 flex-shrink-0">
                    <Clock className="w-5 h-5 text-[#013064]" />
                  </div>
                  <div>
                    <p className="text-white text-base">
                      Setiap hari, 06.00 – 22.00 WIB
                    </p>
                  </div>
                </div>
              </div>

              {/* Right: Google Map */}
              <div className="w-full h-[300px] md:h-[350px] rounded-lg overflow-hidden shadow-lg">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7769479528442!2d107.59060777499649!3d-6.917249193082343!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e745d6ede55f%3A0xc71097dde9e01f90!2sThe%20Arena%20Urban!5e0!3m2!1sid!2sid!4v1766674344955!5m2!1sid!2sid"
                  width="100%"
                  height="100%"
                  style={{ border: 0 }}
                  allowFullScreen=""
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  title="The Arena Urban"
                ></iframe>
              </div>
            </div>
          </div>
        </div>

        {/* Contact Form Section */}
        <div className="bg-[#013064] py-8 md:py-12 px-4">
          <div className="max-w-7xl mx-auto">
            {/* Success Message */}
            {showSuccess && flash?.success && (
              <div className="mb-6 bg-green-500 text-white px-6 py-4 rounded-lg flex items-center gap-3">
                <CheckCircle className="w-6 h-6 flex-shrink-0" />
                <span>{flash.success}</span>
              </div>
            )}

            {/* Auth Warning Message */}
            {showAuthWarning && (
              <div className="mb-6 bg-red-500 text-white px-6 py-4 rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div className="flex items-center gap-3">
                  <AlertCircle className="w-6 h-6 flex-shrink-0" />
                  <span>Anda harus login terlebih dahulu untuk mengirim pesan!</span>
                </div>
                <button
                  onClick={handleLoginRedirect}
                  className="bg-white text-red-500 px-4 py-2 rounded font-semibold hover:bg-gray-100 transition text-sm whitespace-nowrap"
                >
                  Login Sekarang
                </button>
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-5">
              {/* Name and Email Row */}
              <div className="grid md:grid-cols-2 gap-5">
                <div>
                  <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                    Nama
                  </label>
                  <input
                    type="text"
                    placeholder="Nama"
                    value={data.nama}
                    onChange={(e) => setData('nama', e.target.value)}
                    className="w-full px-5 py-3 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] text-sm rounded"
                  />
                  {errors.nama && <p className="text-red-400 text-sm mt-1">{errors.nama}</p>}
                </div>

                <div>
                  <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                    Email
                  </label>
                  <input
                    type="email"
                    placeholder="Email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    className="w-full px-5 py-3 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] text-sm rounded"
                  />
                  {errors.email && <p className="text-red-400 text-sm mt-1">{errors.email}</p>}
                </div>
              </div>

              {/* Subject */}
              <div>
                <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                  Subject
                </label>
                <input
                  type="text"
                  placeholder="Subject"
                  value={data.subject}
                  onChange={(e) => setData('subject', e.target.value)}
                  className="w-full px-5 py-3 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] text-sm rounded"
                />
                {errors.subject && <p className="text-red-400 text-sm mt-1">{errors.subject}</p>}
              </div>

              {/* Message */}
              <div>
                <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                  Pesan
                </label>
                <textarea
                  placeholder="Pesan"
                  rows="5"
                  value={data.pesan}
                  onChange={(e) => setData('pesan', e.target.value)}
                  className="w-full px-5 py-3 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] resize-none text-sm rounded"
                ></textarea>
                {errors.pesan && <p className="text-red-400 text-sm mt-1">{errors.pesan}</p>}
              </div>

              {/* Submit Button */}
              <div>
                <button
                  type="submit"
                  disabled={processing}
                  className="w-full bg-[#ffd22f] text-[#013064] px-8 py-3 text-base font-bold hover:bg-[#ffe066] transition disabled:opacity-50 disabled:cursor-not-allowed rounded"
                >
                  {processing ? 'Mengirim...' : 'Kirim'}
                </button>
              </div>
            </form>
          </div>
        </div>

        {/* ✅ EVENT NOTIF POPUP MODAL - SAMA PERSIS SEPERTI HOMEPAGE */}
        {showEventNotifPopup && activeEventNotif && (
          <div className="fixed inset-0 z-[60] flex items-center justify-center p-4 animate-fade-in">
            {/* Backdrop */}
            <div
              className="absolute inset-0 bg-black/70 backdrop-blur-sm"
              onClick={handleCloseEventNotifPopup}
            />

            {/* Modal Content - COMPACT SIZE WITH SCROLL */}
            <div className="relative bg-white rounded-xl max-w-sm w-full max-h-[85vh] overflow-y-auto shadow-2xl animate-modal-appear border-2 border-gray-800">
              {/* Close Button - STICKY */}
              <button
                onClick={handleCloseEventNotifPopup}
                className="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-all duration-200 hover:scale-110"
              >
                <X className="w-5 h-5 text-gray-800" strokeWidth={3} />
              </button>

              {/* Header */}
              <div className="bg-white px-5 py-4 text-center border-b-2 border-gray-800 sticky top-0 z-20">
                <h2 className="text-base font-black text-gray-900 uppercase tracking-tight mb-1">
                  {activeEventNotif.title}
                </h2>
                <p className="text-[10px] font-bold text-gray-700 uppercase tracking-wide leading-tight">
                  Amankan Slot Sebelum Kuota Habis
                </p>
              </div>

              {/* Date & Time Section - COMPACT */}
              <div className="px-5 py-3 text-center border-b-2 border-gray-800 bg-gray-50">
                <p className="text-xs font-black text-gray-900 uppercase tracking-tight mb-1">
                  {activeEventNotif.formatted_date}
                </p>
                {activeEventNotif.formatted_time && (
                  <p className="text-[10px] font-bold text-gray-700 tracking-wide">
                    Jam {activeEventNotif.formatted_time}
                  </p>
                )}
              </div>

              {/* Pricing Grid - COMPACT */}
              {(activeEventNotif.monthly_price || activeEventNotif.weekly_price) && (
                <>
                  <div className="grid grid-cols-2 gap-3 p-4">
                    {/* Monthly Package */}
                    {activeEventNotif.monthly_price && (
                      <div className="border-2 border-gray-800 rounded-lg p-3">
                        <p className="text-[10px] font-black text-gray-800 uppercase tracking-widest mb-1.5 leading-tight">
                          Bulanan<br />(Lebih Hemat)
                        </p>

                        {activeEventNotif.monthly_discount_percent && activeEventNotif.monthly_original_price && (
                          <p className="text-[9px] text-gray-600 line-through mb-1">
                            Diskon {activeEventNotif.monthly_discount_percent}%
                          </p>
                        )}

                        <p className="text-2xl font-black text-gray-800 mb-1">
                          Rp{activeEventNotif.formatted_monthly_price}
                        </p>

                        <div className="space-y-0.5 text-[9px] text-gray-700 font-bold mb-2 pb-2 border-b-2 border-gray-200">
                          <p>{activeEventNotif.monthly_frequency}</p>
                          <p> +{activeEventNotif.monthly_loyalty_points}</p>
                          {activeEventNotif.monthly_note && <p>{activeEventNotif.monthly_note}</p>}
                        </div>

                        <p className="text-[8px] font-black text-gray-800 uppercase tracking-tight text-center">
                          {activeEventNotif.participant_count}+ Peserta
                        </p>
                      </div>
                    )}

                    {/* Weekly Package */}
                    {activeEventNotif.weekly_price && (
                      <div className="border-2 border-gray-800 rounded-lg p-3 bg-gray-50">
                        <p className="text-[10px] font-black text-gray-800 uppercase tracking-widest mb-2">
                          Mingguan
                        </p>

                        <p className="text-2xl font-black text-gray-800 mb-1">
                          Rp{activeEventNotif.formatted_weekly_price}
                        </p>

                        <p className="text-[9px] font-bold text-gray-700 mb-2">
                          1x pertemuan
                        </p>

                        <div className="space-y-0.5 text-[9px] text-gray-700 font-bold">
                          <p>+{activeEventNotif.weekly_loyalty_points}</p>
                          <p>{activeEventNotif.weekly_note}</p>
                        </div>
                      </div>
                    )}
                  </div>

                  {/* Benefits Section - COMPACT */}
                  <div className="px-4 py-3 bg-gray-50 border-y-2 border-gray-800">
                    <p className="text-[10px] font-black text-gray-800 uppercase tracking-widest mb-2">
                      Termasuk
                    </p>

                    <div className="grid grid-cols-2 gap-x-3 gap-y-1.5 text-[9px] font-bold text-gray-800 mb-2">
                      {activeEventNotif.benefits_list && activeEventNotif.benefits_list.map((benefit, idx) => (
                        <div key={idx}>
                          <p>{benefit.label || benefit}</p>
                        </div>
                      ))}
                    </div>

                    <p className="text-[9px] font-black text-gray-800 uppercase tracking-tight pt-2 border-t-2 border-gray-300 text-center leading-tight">
                      {activeEventNotif.level_tagline}
                    </p>
                  </div>
                </>
              )}

              {/* Description Section */}
              {!activeEventNotif.monthly_price && !activeEventNotif.weekly_price && activeEventNotif.description && (
                <div className="p-4 border-b-2 border-gray-800">
                  <p className="text-[9px] font-bold text-gray-800 leading-relaxed text-center uppercase tracking-wide">
                    {activeEventNotif.description}
                  </p>
                </div>
              )}

              {/* Event Image - COMPACT */}
              {activeEventNotif.image_url && (
                <div className="relative h-32 overflow-hidden mx-4 my-3 rounded-lg border-2 border-gray-800">
                  <img
                    src={activeEventNotif.image_url}
                    alt={activeEventNotif.title}
                    className="w-full h-full object-cover"
                    onError={(e) => {
                      e.target.style.display = 'none';
                    }}
                  />
                </div>
              )}

              {/* Location Info - COMPACT */}
              {activeEventNotif.location && (
                <div className="px-4 py-3 text-center border-t-2 border-gray-800 bg-gray-50">
                  <p className="text-[10px] font-black text-gray-800 uppercase tracking-widest mb-1">
                    Lokasi
                  </p>
                  <p className="text-xs font-bold text-gray-800">
                    {activeEventNotif.location}
                  </p>
                </div>
              )}

              {/* CTA Button - STICKY */}
              <div className="p-4 bg-white border-t-2 border-gray-800 sticky bottom-0 z-20">
                <button
                  onClick={handleRegisterEvent}
                  className="w-full bg-gray-800 text-white py-3 rounded-lg font-black text-xs hover:bg-gray-900 active:scale-95 transition-all duration-200 uppercase tracking-widest border-2 border-gray-800 hover:shadow-lg"
                >
                  Daftar Sekarang
                </button>
              </div>
            </div>
          </div>
        )}

        {/* Footer */}
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