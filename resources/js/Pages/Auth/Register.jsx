import { Head, Link, useForm, router } from "@inertiajs/react";
import { useState } from "react";
import { Phone, Mail, Eye, EyeOff, ArrowLeft, User, Lock, X, CheckCircle, AlertCircle, UserPlus } from "lucide-react";
import Navigation from "../../Components/Navigation";

export default function Register() {
  const [showPassword, setShowPassword] = useState(false);
  const [notification, setNotification] = useState(null);
  
  const { data, setData, post, processing, errors } = useForm({
  username: "",
  email: "",
  phone: "",  // ← TAMBAH INI
  password: "",
});

  const handleSubmit = (e) => {
    e.preventDefault();
    
    post('/register', {
      onSuccess: () => {
        setNotification({
          type: 'success',
          message: 'Registrasi berhasil! Selamat datang, Anda akan dialihkan ke halaman profil...'
        });
        
        setTimeout(() => {
          router.visit('/profile');
        }, 2000);
      },
      onError: (errors) => {
        const errorMessage = errors.username || errors.email || errors.password || 'Terjadi kesalahan saat registrasi';
        setNotification({
          type: 'error',
          message: errorMessage
        });
        setTimeout(() => setNotification(null), 5000);
      }
    });
  };

  return (
    <>
      <Head title="Register" />
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        * {
          font-family: 'Montserrat', sans-serif;
        }
        
        @keyframes slideDown {
          from {
            opacity: 0;
            transform: translateY(-20px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }
        
        @keyframes progress {
          from {
            width: 100%;
          }
          to {
            width: 0%;
          }
        }
        
        @keyframes fadeInUp {
          from {
            opacity: 0;
            transform: translateY(30px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }
        
        @keyframes scaleIn {
          from {
            opacity: 0;
            transform: scale(0.9);
          }
          to {
            opacity: 1;
            transform: scale(1);
          }
        }
        
        @keyframes float {
          0%, 100% {
            transform: translateY(0px);
          }
          50% {
            transform: translateY(-10px);
          }
        }
        
        @keyframes pulse {
          0%, 100% {
            opacity: 1;
          }
          50% {
            opacity: 0.5;
          }
        }
        
        .animate-slide-down {
          animation: slideDown 0.3s ease-out;
        }
        
        .animate-progress {
          animation: progress 5s linear;
        }
        
        .animate-fade-in-up {
          animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-scale-in {
          animation: scaleIn 0.5s ease-out;
        }
        
        .animate-float {
          animation: float 3s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
          animation: pulse 2s ease-in-out infinite;
        }
        
        .stagger-1 {
          animation-delay: 0.1s;
          opacity: 0;
          animation-fill-mode: forwards;
        }
        
        .stagger-2 {
          animation-delay: 0.2s;
          opacity: 0;
          animation-fill-mode: forwards;
        }
        
        .stagger-3 {
          animation-delay: 0.3s;
          opacity: 0;
          animation-fill-mode: forwards;
        }
        
        .stagger-4 {
          animation-delay: 0.4s;
          opacity: 0;
          animation-fill-mode: forwards;
        }
        
        .stagger-5 {
          animation-delay: 0.5s;
          opacity: 0;
          animation-fill-mode: forwards;
        }
      `}</style>
      
      <div className="min-h-screen flex flex-col bg-[#013064] relative overflow-hidden">
        {/* Animated Background Elements */}
        <div className="absolute inset-0 overflow-hidden pointer-events-none">
          <div className="absolute top-10 right-10 w-32 h-32 bg-[#ffd22f]/10 rounded-full blur-3xl animate-float"></div>
          <div className="absolute bottom-40 left-20 w-40 h-40 bg-[#ffd22f]/5 rounded-full blur-3xl animate-float" style={{animationDelay: '1.5s'}}></div>
          <div className="absolute top-1/2 right-1/4 w-36 h-36 bg-[#ffd22f]/10 rounded-full blur-3xl animate-float" style={{animationDelay: '0.5s'}}></div>
        </div>

        {/* Navigation */}
        <Navigation activePage="register" />

        {/* Notification Popup */}
        {notification && (
          <div className="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
            <div
              className="absolute inset-0 bg-[#013064]/80 backdrop-blur-sm"
              onClick={() => setNotification(null)}
            />

            <div className="relative bg-white max-w-md w-full animate-slide-down shadow-2xl">
              <div className={`border-t-4 ${notification.type === 'success' ? 'border-green-500' : 'border-red-500'}`}>
                <div className="bg-[#013064] px-6 py-4 flex items-center justify-between">
                  <div className="flex items-center gap-3">
                    {notification.type === 'success' ? (
                      <CheckCircle className="w-6 h-6 text-green-400" />
                    ) : (
                      <AlertCircle className="w-6 h-6 text-red-400" />
                    )}
                    <h3 className="font-bold text-white text-lg">
                      {notification.type === 'success' ? 'Berhasil' : 'Perhatian'}
                    </h3>
                  </div>
                  <button
                    onClick={() => setNotification(null)}
                    className="text-white/70 hover:text-white transition"
                  >
                    <X className="w-5 h-5" />
                  </button>
                </div>

                <div className="p-6 bg-white">
                  <p className="text-[#013064] text-base leading-relaxed">
                    {notification.message}
                  </p>
                </div>

                <div className="h-1 bg-gray-200 overflow-hidden">
                  <div className={`h-full ${notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'} animate-progress`} />
                </div>
              </div>
            </div>
          </div>
        )}

        {/* Register Form */}
        <main className="flex-1 flex items-center justify-center py-12 px-4 relative z-10">
          <div className="w-full max-w-md relative">
            


            <h1 className="text-[#ffd22f] text-4xl font-bold text-center mb-8 animate-fade-in-up stagger-1">
              Registrasi
            </h1>

            <div className="space-y-6">
              {/* Username Field */}
              <div className="animate-fade-in-up stagger-2">
                <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                  Username
                </label>
                <div className="relative">
                  <User className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <input
                    type="text"
                    placeholder="Username"
                    value={data.username}
                    onChange={(e) => setData('username', e.target.value)}
                    className="w-full pl-12 pr-4 py-3 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] transition"
                  />
                </div>
                {errors.username && (
                  <p className="text-red-400 text-xs mt-1 flex items-center gap-1">
                    <AlertCircle className="w-3 h-3" />
                    {errors.username}
                  </p>
                )}
              </div>

              {/* Email Field */}
              <div className="animate-fade-in-up stagger-3">
                <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                  Email
                </label>
                <div className="relative">
                  <Mail className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <input
                    type="email"
                    placeholder="Email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    className="w-full pl-12 pr-4 py-3 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] transition"
                  />
                </div>
                {errors.email && (
                  <p className="text-red-400 text-xs mt-1 flex items-center gap-1">
                    <AlertCircle className="w-3 h-3" />
                    {errors.email}
                  </p>
                )}
              </div>
              <div className="animate-fade-in-up stagger-3">
  <label className="block text-[#ffd22f] text-sm font-medium mb-2">
    Nomor Telepon <span className="text-red-400">*</span>
  </label>
  <div className="relative">
    <Phone className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
    <input
      type="tel"
      placeholder="08123456789"
      value={data.phone}
      onChange={(e) => setData('phone', e.target.value)}
      required
      className="w-full pl-12 pr-4 py-3 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] transition"
    />
  </div>
  {errors.phone && (
    <p className="text-red-400 text-xs mt-1 flex items-center gap-1">
      <AlertCircle className="w-3 h-3" />
      {errors.phone}
    </p>
  )}
</div>

              {/* Password Field */}
              <div className="animate-fade-in-up stagger-4">
                <label className="block text-[#ffd22f] text-sm font-medium mb-2">
                  Password
                </label>
                <div className="relative">
                  <Lock className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <input
                    type={showPassword ? "text" : "password"}
                    placeholder="Password"
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                    className="w-full pl-12 pr-12 py-3 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ffd22f] transition"
                  />
                  <button
                    type="button"
                    onClick={() => setShowPassword(!showPassword)}
                    className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800 transition"
                  >
                    {showPassword ? (
                      <EyeOff className="w-5 h-5" />
                    ) : (
                      <Eye className="w-5 h-5" />
                    )}
                  </button>
                </div>
                {errors.password && (
                  <p className="text-red-400 text-xs mt-1 flex items-center gap-1">
                    <AlertCircle className="w-3 h-3" />
                    {errors.password}
                  </p>
                )}
              </div>

              {/* Submit Button */}
              <button
                type="button"
                onClick={handleSubmit}
                disabled={processing}
                className="w-full bg-[#ffd22f] text-[#013064] py-3 font-bold text-lg hover:bg-[#ffe066] transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 animate-fade-in-up stagger-5 shadow-lg hover:shadow-xl"
              >
                {processing ? (
                  <>
                    <div className="w-5 h-5 border-2 border-[#013064] border-t-transparent rounded-full animate-spin"></div>
                    Memproses...
                  </>
                ) : (
                  <>
                    <UserPlus className="w-5 h-5" />
                    Daftar
                  </>
                )}
              </button>

              {/* Login Link */}
              <p className="text-center text-white text-sm animate-fade-in-up stagger-5">
                Sudah punya akun?{" "}
                <Link
                  href="/login"
                  className="text-[#ffd22f] hover:underline font-semibold"
                >
                  Login di sini
                </Link>
              </p>
            </div>
          </div>
        </main>
      </div>
    </>
  );
}