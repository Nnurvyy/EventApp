<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-teal-500 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-teal-600 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-300 focus:ring-offset-2 transition duration-200 shadow-md hover:shadow-lg hover:scale-102 active:scale-98 transform cursor-pointer']) }}>
    {{ $slot }}
</button>
