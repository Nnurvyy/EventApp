<div {{ $attributes->merge(['class' => 'bg-gradient-to-tr from-emerald-100/30 to-cyan-100/30 flex items-center justify-center relative overflow-hidden']) }}>
    <!-- Decorative floating sparkles -->
    <span class="absolute top-4 left-4 text-emerald-300 text-xs select-none">✨</span>
    <span class="absolute bottom-4 right-4 text-cyan-300 text-xs select-none">✨</span>

    <!-- Cute Smiling Calendar SVG -->
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-1/3 h-1/3 max-w-[64px] transition-transform duration-300 hover:scale-110">
        <!-- Calendar Base -->
        <rect x="15" y="25" width="70" height="60" rx="14" fill="#ffffff" stroke="#cbd5e1" stroke-width="2.5" />
        <!-- Header Bar -->
        <path d="M15 39c0-7.732 6.268-14 14-14h42c7.732 0 14 6.268 14 14v4H15v-4z" fill="#0f766e" />
        
        <!-- Binder Rings -->
        <rect x="30" y="15" width="6" height="14" rx="3" fill="#94a3b8" />
        <rect x="64" y="15" width="6" height="14" rx="3" fill="#94a3b8" />
        
        <!-- Smiley Face -->
        <!-- Eyes -->
        <circle cx="38" cy="62" r="3.5" fill="#1e293b" />
        <circle cx="62" cy="62" r="3.5" fill="#1e293b" />
        <!-- Blush -->
        <circle cx="31" cy="67" r="4.5" fill="#a7f3d0" opacity="0.8" />
        <circle cx="69" cy="67" r="4.5" fill="#a7f3d0" opacity="0.8" />
        <!-- Smile -->
        <path d="M46 66c0 1.93 1.57 3.5 3.5 3.5s3.5-1.57 3.5-3.5" stroke="#1e293b" stroke-width="2.5" stroke-linecap="round" fill="none" />
        
        <!-- Tiny Sparkle on calendar -->
        <path d="M75 32l1.5 3 3 1.5-3 1.5-1.5 3-1.5-3-3-1.5 3-1.5z" fill="#2dd4bf" />
    </svg>
</div>
