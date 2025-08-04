import clsx from "clsx";

export default function AppButton({
  disabled = false,
  onClick,
  className = "",
  children,
  type = "button",
}) {
  const baseClass =
    "py-2.5 px-5 me-2 mb-2 cursor-pointer flex justify-center items-center gap-2 font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700";

  return (
    <button
      type={type}
      disabled={disabled}
      onClick={onClick}
      className={clsx(
        baseClass,
        className,
        disabled && "opacity-60 cursor-not-allowed"
      )}
    >
      {children}
    </button>
  );
}
