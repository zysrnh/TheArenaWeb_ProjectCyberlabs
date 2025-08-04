import { Head, useForm, usePage } from "@inertiajs/react";
import FormField from "../Components/Forms/FormField";
import LoadingSpinner from "../Components/UI/LoadingSpinner";
import toast, { Toaster } from "react-hot-toast";
import { useEffect } from "react";

// const DarkModeToggle = ({ isDark, onToggle }) => (
//   <button
//     type="button"
//     onClick={onToggle}
//     className="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
//     aria-label={isDark ? "Switch to light mode" : "Switch to dark mode"}
//   >
//     {isDark ? <MoonIcon /> : <SunIcon />}
//   </button>
// );

export default function Registration({ form_data }) {
  // const [isDark, setIsDark] = useState(false);
  const { flash } = usePage().props;
  const { data, setData, post, processing, errors } = useForm({
    name: form_data?.name ?? '',
    email: form_data?.email ?? '',
    phone: form_data?.phone ?? '',
  });

  const handleSubmit = (e) => {
    if (processing) return;

    e.preventDefault();
    post(route("user.submit_registration"), data);
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
      <Head title="Register" />
      <Toaster />
      <div className="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div className="max-w-3xl mx-auto px-4">
          <form
            id="form"
            onSubmit={handleSubmit}
            className="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md border dark:border-gray-700"
          >
            {/* Header */}
            <div className="flex justify-between items-start mb-6">
              <h1 className="text-2xl font-bold text-gray-800 dark:text-white">
                Harap isi form berikut
              </h1>
              {/* <DarkModeToggle
                isDark={isDark}
                onToggle={() => setIsDark(!isDark)}
              /> */}
            </div>

            {/* Form Fields */}
            <div className="space-y-4">
              <FormField
                label="Nama Lengkap"
                id="name"
                value={data.name}
                error={errors.name}
                onChange={(e) => setData("name", e.target.value)}
              />
              <FormField
                label="Email"
                id="email"
                type="email"
                value={data.email}
                error={errors.email}
                onChange={(e) => setData("email", e.target.value)}
              />
              <FormField
                label="Nomor WhatsApp"
                id="phone"
                type="tel"
                placeholder="08xxxxxxxx"
                value={data.phone}
                error={errors.phone}
                onChange={(e) => setData("phone", e.target.value)}
              />
            </div>

            {/* Submit Button */}
            <div className="mt-8 flex justify-end">
              <button
                type="submit"
                disabled={processing}
                className="px-6 py-2 font-semibold cursor-pointer text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
              >
                {processing ? <LoadingSpinner /> : "Submit"}
              </button>
            </div>
          </form>
        </div>
      </div>
    </>
  );
}
