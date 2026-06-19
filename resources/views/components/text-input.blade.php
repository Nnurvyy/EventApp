@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-teal-400 focus:ring-teal-200 focus:ring rounded-2xl shadow-sm text-slate-800 transition duration-150 bg-white/70 backdrop-blur-sm']) }}>
