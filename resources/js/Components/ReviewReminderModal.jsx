import { useState, useEffect } from "react";
import { Star, X } from "lucide-react";
import { router } from "@inertiajs/react";

export default function ReviewReminderModal({ shouldShow, completedBookingCount }) {
  const [showModal, setShowModal] = useState(false);
  const [rating, setRating] = useState({
    facilities: 0,
    hospitality: 0,
    cleanliness: 0
  });
  const [hoverRating, setHoverRating] = useState({
    facilities: 0,
    hospitality: 0,
    cleanliness: 0
  });
  const [comment, setComment] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    // ✅ DEBUGGING LOGS
    console.log('🔍 ReviewReminderModal Props:', { 
      shouldShow, 
      completedBookingCount,
      typeOfShouldShow: typeof shouldShow,
      typeOfCount: typeof completedBookingCount
    });
    
    // Cek apakah sudah dismiss hari ini
    const dismissedDate = localStorage.getItem('review_reminder_dismissed_date');
    const today = new Date().toDateString();
    
    console.log('🗓️ Dismiss Check:', { 
      dismissedDate, 
      today, 
      isDismissed: dismissedDate === today 
    });
    
    if (dismissedDate === today) {
      console.log('❌ Modal dismissed today, not showing');
      return;
    }

    // Tampilkan modal jika shouldShow = true
    if (shouldShow) {
      console.log('✅ Will show modal in 1 second');
      setTimeout(() => {
        setShowModal(true);
        console.log('✅ Modal state set to true!');
      }, 1000);
    } else {
      console.log('❌ shouldShow is false or undefined');
    }
  }, [shouldShow]);

  const handleDismiss = () => {
    // Tutup modal saja, akan muncul lagi saat refresh
    setShowModal(false);
  };

  const handleDismissToday = () => {
    setShowModal(false);
    // Simpan tanggal dismiss agar tidak muncul lagi hari ini
    const today = new Date().toDateString();
    localStorage.setItem('review_reminder_dismissed_date', today);
  };

  const handleSubmitReview = async (e) => {
    e.preventDefault();
    
    // Validasi
    if (rating.facilities === 0 || rating.hospitality === 0 || rating.cleanliness === 0) {
      alert('Mohon berikan rating untuk semua aspek');
      return;
    }
    
    if (comment.trim().length < 10) {
      alert('Komentar minimal 10 karakter');
      return;
    }

    setIsSubmitting(true);

    try {
      const response = await fetch('/api/booking/reviews', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
          rating_facilities: rating.facilities,
          rating_hospitality: rating.hospitality,
          rating_cleanliness: rating.cleanliness,
          comment: comment
        })
      });

      const data = await response.json();

      if (data.success) {
        alert(data.message);
        setShowModal(false);
        // Hapus dismiss flag karena sudah submit review
        localStorage.removeItem('review_reminder_dismissed_date');
        // Refresh halaman
        router.reload();
      } else {
        alert(data.message || 'Gagal mengirim ulasan');
      }
    } catch (error) {
      alert('Terjadi kesalahan saat mengirim ulasan');
      console.error(error);
    } finally {
      setIsSubmitting(false);
    }
  };

  const renderStars = (category, currentRating, currentHover) => {
    return (
      <div className="flex gap-1">
        {[1, 2, 3, 4, 5].map((star) => (
          <button
            key={star}
            type="button"
            onClick={() => setRating(prev => ({ ...prev, [category]: star }))}
            onMouseEnter={() => setHoverRating(prev => ({ ...prev, [category]: star }))}
            onMouseLeave={() => setHoverRating(prev => ({ ...prev, [category]: 0 }))}
            className="focus:outline-none transition-transform hover:scale-110"
          >
            <Star
              className={`w-8 h-8 ${
                star <= (currentHover || currentRating)
                  ? 'fill-[#ffd22f] text-[#ffd22f]'
                  : 'text-gray-300'
              }`}
            />
          </button>
        ))}
      </div>
    );
  };

  if (!showModal) return null;

  return (
    <div className="fixed inset-0 bg-black/60 flex items-center justify-center z-[9999] p-4 animate-fade-in">
      <div className="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl animate-slide-up">
        {/* Header */}
        <div className="bg-gradient-to-r from-[#013064] to-[#024b8a] p-6 relative">
          <button
            onClick={handleDismiss}
            className="absolute top-4 right-4 text-white/80 hover:text-white transition"
            aria-label="Tutup"
          >
            <X className="w-6 h-6" />
          </button>
          <h2 className="text-2xl font-bold text-white mb-2">
            🏀 Bagikan Pengalaman Anda!
          </h2>
          <p className="text-white/90">
            Anda telah menyelesaikan {completedBookingCount} booking. Bantu kami meningkatkan layanan dengan memberikan ulasan.
          </p>
        </div>

        {/* Form */}
        <form onSubmit={handleSubmitReview} className="p-6 space-y-6">
          {/* Rating Facilities */}
          <div>
            <label className="block text-[#013064] font-semibold mb-3">
              Fasilitas Lapangan
            </label>
            {renderStars('facilities', rating.facilities, hoverRating.facilities)}
          </div>

          {/* Rating Hospitality */}
          <div>
            <label className="block text-[#013064] font-semibold mb-3">
              Keramahan Staff
            </label>
            {renderStars('hospitality', rating.hospitality, hoverRating.hospitality)}
          </div>

          {/* Rating Cleanliness */}
          <div>
            <label className="block text-[#013064] font-semibold mb-3">
              Kebersihan
            </label>
            {renderStars('cleanliness', rating.cleanliness, hoverRating.cleanliness)}
          </div>

          {/* Comment */}
          <div>
            <label className="block text-[#013064] font-semibold mb-3">
              Ceritakan Pengalaman Anda
            </label>
            <textarea
              value={comment}
              onChange={(e) => setComment(e.target.value)}
              rows="4"
              className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#ffd22f] resize-none"
              placeholder="Bagikan pengalaman Anda bermain di The Arena Basketball... (minimal 10 karakter)"
              required
              minLength={10}
              maxLength={1000}
            />
            <p className="text-sm text-gray-500 mt-2">
              {comment.length}/1000 karakter
            </p>
          </div>

          {/* Buttons */}
          <div className="flex flex-col sm:flex-row gap-3">
            <button
              type="button"
              onClick={handleDismissToday}
              className="px-4 py-3 bg-gray-100 text-gray-600 rounded-lg font-medium hover:bg-gray-200 transition text-sm border border-gray-300"
            >
              🚫 Jangan Tampilkan Hari Ini
            </button>
            <button
              type="button"
              onClick={handleDismiss}
              className="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition"
            >
              Nanti Saja
            </button>
            <button
              type="submit"
              disabled={isSubmitting}
              className="px-6 py-3 bg-[#ffd22f] text-[#013064] rounded-lg font-bold hover:bg-[#ffe066] transition disabled:opacity-50 disabled:cursor-not-allowed shadow-md"
            >
              {isSubmitting ? '⏳ Mengirim...' : '✨ Kirim Ulasan'}
            </button>
          </div>
        </form>
      </div>

      <style jsx>{`
        @keyframes fade-in {
          from { opacity: 0; }
          to { opacity: 1; }
        }
        @keyframes slide-up {
          from {
            transform: translateY(20px);
            opacity: 0;
          }
          to {
            transform: translateY(0);
            opacity: 1;
          }
        }
        .animate-fade-in {
          animation: fade-in 0.3s ease-out;
        }
        .animate-slide-up {
          animation: slide-up 0.4s ease-out;
        }
      `}</style>
    </div>
  );
}