export default function FormField({
  label,
  id,
  type = "text",
  placeholder,
  required = false,
  value = "",
  onChange,
  error,
}) {
  return (
    <div className="space-y-1">
      <label
        htmlFor={id}
        className="block text-sm font-medium text-gray-700 dark:text-white"
      >
        {label} {required && <span className="text-red-500">*</span>}
      </label>
      {error && <span className="text-sm text-red-500">{error}</span>}
      <input
        type={type}
        id={id}
        name={id}
        placeholder={placeholder}
        required={required}
        value={value}
        onChange={onChange}
        className="w-full rounded-lg border border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
      />
    </div>
  );
}
