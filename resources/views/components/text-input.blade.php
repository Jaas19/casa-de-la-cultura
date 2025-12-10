@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-yellow-950 dark:border-yellow-950 bg-[#efefef] dark:bg-[#2b2b2b] text-[#323232] dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md border-2']) }}>
