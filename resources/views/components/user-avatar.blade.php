@props(['user', 'class' => 'w-10 h-10'])

@php
    $avatar = $user->avatar ?? null;
    $isExternal = $avatar && (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://'));
    $avatarUrl = $avatar ? ($isExternal ? $avatar : asset('storage/' . $avatar)) : null;
@endphp

@if ($avatarUrl)
    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="{{ $class }} rounded-full object-cover border-2 border-slate-800 shadow-[1px_1px_0px_0px_rgba(30,41,59,1)]">
@else
    <!-- Fallback cute avatar without dog (anjing) -->
    <div class="{{ $class }} rounded-full border-2 border-slate-800 bg-teal-100 flex items-center justify-center shadow-[1px_1px_0px_0px_rgba(30,41,59,1)] select-none">
        @php
            // Cute animal emojis excluding dog (🐶)
            $emojis = ['🐱', '🦊', '🐻', '🐼', '🐸', '🐹', '🐰', '🦁', '🐨', '🐷', '🐯', '🐮', '🐑', '🐧', '🦉', '🐣'];
            $emoji = $emojis[$user->id % count($emojis)] ?? '🐱';
        @endphp
        <span class="text-sm md:text-base leading-none">{{ $emoji }}</span>
    </div>
@endif
