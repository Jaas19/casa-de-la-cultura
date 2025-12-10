<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-yellow-950 border border-transparent rounded-full font-semibold text-xs text-white dark:text-[#f8f8f8] uppercase tracking-widest dark:hover:text-yellow-950 hover:bg-gray-700 dark:hover:bg-[#f8f8f8] focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
