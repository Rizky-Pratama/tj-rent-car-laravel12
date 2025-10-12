@props(['breadcrumbs'])

<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        @foreach ($breadcrumbs as $index => $breadcrumb)
            @if ($index > 0)
                <li class="flex items-center">
                    <iconify-icon icon="heroicons:chevron-right-20-solid"
                        class="w-4 h-4 text-gray-400 mx-2"></iconify-icon>
                </li>
            @endif
            <li class="flex items-center">
                @if (isset($breadcrumb['url']) && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                        {{ $breadcrumb['title'] }}
                    </a>
                @else
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $breadcrumb['title'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
