@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 mt-8">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/70 border border-slate-100 text-slate-350 cursor-not-allowed select-none">
                ⬅️
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200/60 text-slate-600 hover:bg-teal-50 hover:text-teal-600 hover:scale-105 active:scale-95 shadow-sm transition duration-150 transform cursor-pointer">
                ⬅️
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-10 h-10 text-slate-400">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-teal-500 text-white font-bold shadow-md select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200/60 text-slate-600 hover:bg-teal-50 hover:text-teal-600 hover:scale-105 active:scale-95 shadow-sm transition duration-150 transform cursor-pointer">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200/60 text-slate-600 hover:bg-teal-50 hover:text-teal-600 hover:scale-105 active:scale-95 shadow-sm transition duration-150 transform cursor-pointer">
                ➡️
            </a>
        @else
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100/70 border border-slate-100 text-slate-350 cursor-not-allowed select-none">
                ➡️
            </span>
        @endif
    </nav>
@endif
