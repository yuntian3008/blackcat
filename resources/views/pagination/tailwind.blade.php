@if ($paginator->hasPages())
<div class="flex">
    @if ($paginator->onFirstPage())
        <a href="#" class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
            @lang('pagination.previous')
        </a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200">
            @lang('pagination.previous')
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a href="#" class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                {{ $element }}
            </a>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="#" class="flex items-center px-4 py-2 mx-1 text-white transition-colors duration-200 transform bg-gray-700 rounded-md dark:bg-gray-200 dark:text-gray-700 hover:bg-gray-600 dark:hover:bg-gray-300">
                        {{ $page }}
                    </a>
                @else
                    <a href="{{ $url }}" class="flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200">
            @lang('pagination.next')
        </a>
    @else
        <a href="#" class="flex items-center px-4 py-2 mx-1 text-gray-500 bg-white rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
            @lang('pagination.next')
        </a>
    @endif
</div>
@endif