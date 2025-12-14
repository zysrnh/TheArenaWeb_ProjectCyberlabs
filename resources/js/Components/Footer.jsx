import { Link } from "@inertiajs/react";
import { Instagram, Music, Youtube, MessageCircle } from "lucide-react";

export default function Footer() {
  return (
    <>
      {/* Footer */}
      <footer className="bg-[#ffd22f] py-12 md:py-16 px-4">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12 mb-8 md:mb-12">
            {/* Logo & Description */}
            <div className="md:col-span-2 lg:col-span-1 text-center md:text-left">
              <img 
                src="/images/LogoHitam.png" 
                alt="The Arena Basketball" 
                className="h-20 md:h-24 w-auto mb-4 md:mb-6 mx-auto md:mx-0" 
              />
              <p className="text-[#013064] text-sm leading-relaxed px-4 md:px-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
              </p>
            </div>

            {/* Menu */}
            <div className="text-center md:text-left">
              <h3 className="text-[#013064] text-lg md:text-xl font-bold mb-4 md:mb-6">Menu</h3>
              <ul className="space-y-2 md:space-y-3 text-[#013064] text-sm md:text-base">
                <li><Link href="/berita" className="hover:underline">Berita</Link></li>
                <li><Link href="/faq" className="hover:underline">FAQ</Link></li>
                <li><Link href="/jadwal-hasil" className="hover:underline">Jadwal</Link></li>
                <li><Link href="/siaran-langsung" className="hover:underline">Siaran Langsung</Link></li>
                <li><Link href="/sponsor" className="hover:underline">Partner dan Sponsor</Link></li>
              </ul>
            </div>

            {/* Legal */}
            <div className="text-center md:text-left">
              <h3 className="text-[#013064] text-lg md:text-xl font-bold mb-4 md:mb-6">Legal</h3>
              <ul className="space-y-2 md:space-y-3 text-[#013064] text-sm md:text-base">
                <li><Link href="/kebijakan-privasi" className="hover:underline">Kebijakan Privasi</Link></li>
                <li><Link href="/syarat-layanan" className="hover:underline">Syarat Layanan</Link></li>
                <li><Link href="/license" className="hover:underline">License Agreement</Link></li>
                <li><Link href="/ketentuan" className="hover:underline">Ketentuan Penggunaan</Link></li>
                <li><Link href="/komunitas" className="hover:underline">Komunitas</Link></li>
              </ul>
            </div>

            {/* Contact */}
            <div className="text-center md:text-left">
              <h3 className="text-[#013064] text-lg md:text-xl font-bold mb-4 md:mb-6">Kontak</h3>
              <div className="space-y-3 md:space-y-4">
                <div className="flex items-center gap-3 justify-center md:justify-start">
                  <img src="/images/Phone_fill-1.svg" alt="Phone" className="w-5 h-5 flex-shrink-0" />
                  <span className="text-[#013064] text-sm md:text-base">0812-3456-789</span>
                </div>
                <div className="flex items-center gap-3 justify-center md:justify-start">
                  <img src="/images/Message_alt_fill-2.svg" alt="Email" className="w-5 h-5 flex-shrink-0" />
                  <span className="text-[#013064] text-sm md:text-base break-all">thearena@gmail.com</span>
                </div>
                <div className="flex items-start gap-3 justify-center md:justify-start px-4 md:px-0">
                  <img src="/images/Pin_fill.svg" alt="Location" className="w-5 h-5 mt-1 flex-shrink-0" />
                  <span className="text-[#013064] text-sm text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                </div>
                
                {/* Social Media Icons */}
                <div className="flex gap-3 pt-2 md:pt-4 justify-center md:justify-start">
                  <a 
                    href="https://instagram.com" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="w-9 h-9 md:w-10 md:h-10 bg-[#013064] rounded-full flex items-center justify-center hover:opacity-80 transition"
                    aria-label="Instagram"
                  >
                    <Instagram className="w-4 h-4 md:w-5 md:h-5 text-white" />
                  </a>
                  <a 
                    href="https://tiktok.com" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="w-9 h-9 md:w-10 md:h-10 bg-[#013064] rounded-full flex items-center justify-center hover:opacity-80 transition"
                    aria-label="TikTok"
                  >
                    <Music className="w-4 h-4 md:w-5 md:h-5 text-white" />
                  </a>
                  <a 
                    href="https://youtube.com" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="w-9 h-9 md:w-10 md:h-10 bg-[#013064] rounded-full flex items-center justify-center hover:opacity-80 transition"
                    aria-label="YouTube"
                  >
                    <Youtube className="w-4 h-4 md:w-5 md:h-5 text-white" />
                  </a>
                  <a 
                    href="https://wa.me/6281234567890" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="w-9 h-9 md:w-10 md:h-10 bg-[#013064] rounded-full flex items-center justify-center hover:opacity-80 transition"
                    aria-label="WhatsApp"
                  >
                    <MessageCircle className="w-4 h-4 md:w-5 md:h-5 text-white" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>

      {/* Copyright Bar */}
      <div className="bg-[#013064] py-4 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <p className="text-white text-xs md:text-sm leading-relaxed">
            © Copyright The Arena All Rights Reserved. Design & Development By CyberLabs
          </p>
        </div>
      </div>
    </>
  );
}