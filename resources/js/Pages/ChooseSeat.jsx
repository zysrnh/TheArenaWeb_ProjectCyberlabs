import { Head, router, useForm, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";
import LoadingSpinner from "../Components/UI/LoadingSpinner";
import OutlineButton from "../Components/Forms/OutlineButton";
import toast, { Toaster } from "react-hot-toast";

export default function ChooseSeat({
  seatingType,
  seats,
  formData,
  maxColumnCount,
}) {
  const { flash } = usePage().props;
  const [isGoingBack, setIsGoingBack] = useState(false);
  const { data, setData, post, processing, errors } = useForm({
    seat: null,
    seat_id: null,
  });

  const chooseSeat = (seat) => {
    if (!seat.is_available) {
      toast.error("Kursi telah terisi");
      return;
    }

    setData({
      seat: seat,
      seat_id: seat.id,
    });
  };

  const handleSubmit = () => {
    post(route("user.submit_seat"), {
      seat_id: data.seat.id,
    });
  };

  const goBack = () => {
    if (isGoingBack) return;

    setIsGoingBack(true);
    router.get(route("user.registration"));
  };

  useEffect(() => {
    if (!flash?.info) return;
    
    const info = flash.info;

    // Handle different info types
    if (typeof info === "string") {
      toast(info);
    } else if (typeof info === "object") {
      // Handle your backend format: ['error' => 'info']
      if (info.error) {
        toast.error(info.error);
      } else if (info.success) {
        toast.success(info.success);
      } else if (info.info) {
        toast.info(info.info);
      } else if (info.warning) {
        toast.warning(info.warning);
      }
    }
  }, [flash?.info]);

  return (
    <>
      <Head title="Pilih Kursi" />
      <Toaster />
      <div className="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div className="max-w-6xl mx-auto px-4">
          <div className="flex justify-between items-start mb-6">
            {/* Container */}
            <div className="bg-white w-full dark:bg-gray-800 p-8 rounded-lg shadow-md border dark:border-gray-700">
              <OutlineButton disabled={isGoingBack} onClick={goBack}>
                {isGoingBack ? (
                  <LoadingSpinner />
                ) : (
                  <>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth={1.5}
                      stroke="currentColor"
                      className="size-6"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                      />
                    </svg>
                    <span>Edit Informasi Saya</span>
                  </>
                )}
              </OutlineButton>

              <h1 className="text-2xl font-bold text-gray-800 dark:text-white">
                Pilih Kursi Anda
              </h1>
              {/* <DarkModeToggle
                isDark={isDark}
                onToggle={() => setIsDark(!isDark)}
              /> */}

              {/* Info */}
              <div className="my-4">
                <hr className="text-gray-300" />

                <table className="text-gray-800 my-4">
                  <tbody>
                    <tr>
                      <td>Nama</td>
                      <td className="px-1">:</td>
                      <td className="px-1">{formData.name}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td className="px-1">:</td>
                      <td className="px-1">{formData.email}</td>
                    </tr>
                    <tr>
                      <td>Nomor Whatsapp</td>
                      <td className="px-1">:</td>
                      <td className="px-1">{formData.phone}</td>
                    </tr>
                  </tbody>
                </table>

                <hr className="text-gray-300" />
              </div>

              {/* Seating */}
              <div className="overflow-x-auto w-full">
                <div
                  className="grid gap-2"
                  style={{
                    gridTemplateColumns: `repeat(${maxColumnCount}, minmax(50px, 1fr))`,
                  }}
                >
                  {seats.map((seat) => (
                    <button
                      key={seat.id}
                      onClick={() => chooseSeat(seat)}
                      style={{
                        gridColumnStart: seat.column,
                        gridRowStart: seat.row,
                      }}
                      className={`p-3 cursor-pointer rounded-md text-center flex justify-center items-center
                        ${
                          seat.is_available
                            ? data.seat?.id === seat.id
                              ? "bg-blue-700 text-white"
                              : "bg-gray-200 hover:bg-blue-700 hover:text-white"
                            : "bg-gray-400 text-gray-600"
                        }`}
                    >
                      {seat.label}
                    </button>
                  ))}
                </div>
              </div>

              {/* Submit */}
              {data.seat?.id && (
                <div className="mt-4 w-full flex justify-end">
                  <button
                    type="button"
                    onClick={handleSubmit}
                    className="px-4 py-2 mb-3 font-semibold cursor-pointer text-white flex justify-center items-center gap-2 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                  >
                    {processing ? (
                      <LoadingSpinner />
                    ) : (
                      <>Pilih Kursi {data.seat.label}</>
                    )}
                  </button>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
