{{-- <li><a class="dropdown-item d-flex justify-content-between" href="{{ url( $category->category_slug) }}">{{ $category->category_name }} @if (count($category->childrenRecursive) > 0) <i class="bi bi-chevron-right"></i>  @endif</a>

    @if (count($category->childrenRecursive) > 0)
        <ul class="submenu dropdown-menu fsize-16">
        @foreach($category->childrenRecursive as $category)
            @include('layouts.web.subcategories', $category)
        @endforeach
        </ul>
    @endif
</li> --}}
@if (count($category->childrenRecursive) > 0)

<li class="rounded-sm relative px-4 py-2 hover:bg-gray-100">
    <a
    class="w-full text-left flex items-center outline-none focus:outline-none"
    href="{{ url( 'shop/'.$category->category_slug) }}"
    >
        <span class="pr-1 flex-1">{{ $category->category_name }}</span>
        <span class="mr-auto">
          <svg
            class="fill-current h-4 w-4
            transition duration-150 ease-in-out"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <path
              d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
            />
          </svg>
        </span>
    </a>
    <ul
    class="bg-white border rounded-lg absolute top-0 right-0 
    transition duration-150 ease-in-out origin-top-left
    min-w-32
    ">
    @foreach($category->childrenRecursive as $category)
        @include('layouts.web.subcategories', $category)
    @endforeach
    </ul>
@else
<li class="rounded-sm px-4 py-2 hover:bg-gray-100"><a
    class="w-full text-left flex items-center outline-none focus:outline-none"
    href="{{ url( 'shop/'.$category->category_slug) }}"
    >
        <span class="pr-1 flex-1">{{ $category->category_name }}</span>
    </a></li>
@endif
