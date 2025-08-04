import { Head } from "@inertiajs/react";
import { Toaster } from "react-hot-toast";

export default function RegistrationSuccess({ registration, success_image }) {
  return (
    <>
      <Head title="Register" />
      <Toaster />
      <div className="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div className="max-w-3xl mx-auto px-4">
          <div className="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md border dark:border-gray-700">
            {/* Header */}
            <div className="flex justify-center items-start mb-1">
              <h1 className="text-2xl font-bold text-gray-800 dark:text-white">
                Registrasi Berhasil
              </h1>
              {/* <DarkModeToggle
                isDark={isDark}
                onToggle={() => setIsDark(!isDark)}
              /> */}
            </div>

            <div className="w-full flex flex-col justify-center items-center my-10">
              <img
                src={success_image}
                alt="Success Image"
                className="w-full sm:w-1/2 md:w-10/12 lg:w-9/12 h-auto"
              />

              <h2 className="text-2xl sm:text-2xl md:text-2xl lg:text-2xl font-semibold">
                Data Anda
              </h2>

              <div className="w-full grid grid-cols-1 md:grid-cols-2 md:justify-items-start gap-5 md:gap-3 my-6">
                <div className="flex flex-col">
                  <span className="text-lg text-gray-600 font-semibold">
                    Nama
                  </span>
                  <span className="text-2xl font-semibold">{registration.name}</span>
                </div>
                <div className="flex flex-col">
                  <span className="text-lg text-gray-600 font-semibold">
                    Email
                  </span>
                  <span className="text-2xl font-semibold">{registration.email}</span>
                </div>
                <div className="flex flex-col">
                  <span className="text-lg text-gray-600 font-semibold">
                    Nomor Telepon (Whatsapp)
                  </span>
                  <span className="text-2xl font-semibold">{registration.phone}</span>
                </div>
                <div className="flex flex-col">
                  <span className="text-lg text-gray-600 font-semibold">
                    Nomor Kursi
                  </span>
                  <span className="text-2xl text-blue-600 font-bold">
                    {registration.seat.label}
                  </span>
                </div>
              </div>

              <div className="w-full mt-4">
                <a
                  href={route('user.registration')}
                  type="button"
                  className="block w-full px-6 py-2 font-semibold cursor-pointer text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                >
                  <span className="w-full flex justify-center">Kembali ke registrasi</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
