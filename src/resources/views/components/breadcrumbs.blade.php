@if (!empty($breadcrumbs))
    <nav aria-label="Breadcrumb" class="bg-white px-4 py-3 shadow-sm rounded-lg">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="flex items-center">
                    @if (!$loop->last)
                        <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-blue-600 transition-colors duration-200">
                            {{ $breadcrumb['label'] }}
                        </a>
                        <svg class="h-4 w-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <span class="font-medium text-gray-900">{{ $breadcrumb['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif