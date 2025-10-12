@props(['title', 'value', 'icon', 'color' => 'indigo', 'trend' => null, 'trendValue' => null])

<div
    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $title }}</p>
            <div class="flex items-baseline space-x-2">
                <p class="text-2xl font-bold text-gray-900 dark:text-white" x-data="{ count: 0, target: {{ $value }} }" x-init="let start = 0;
                let duration = 1000;
                let startTime = null;
                
                function animate(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    let progress = (currentTime - startTime) / duration;
                
                    if (progress < 1) {
                        count = Math.floor(start + (target - start) * progress);
                        requestAnimationFrame(animate);
                    } else {
                        count = target;
                    }
                }
                
                requestAnimationFrame(animate);"
                    x-text="
                       @if (strpos($value, '.') !== false || $value >= 1000000) new Intl.NumberFormat('id-ID', {
                               style: 'currency',
                               currency: 'IDR',
                               minimumFractionDigits: 0,
                               maximumFractionDigits: 0
                           }).format(count)
                       @elseif($value >= 1000)
                           new Intl.NumberFormat('id-ID').format(count)
                       @else
                           count @endif
                   ">
                    0</p>

                @if ($trend && $trendValue)
                    <div
                        class="flex items-center text-xs font-medium {{ $trend === 'up' ? 'text-emerald-600' : 'text-red-600' }}">
                        @if ($trend === 'up')
                            <iconify-icon icon="heroicons:arrow-trending-up-20-solid"
                                class="w-3 h-3 mr-1"></iconify-icon>
                        @else
                            <iconify-icon icon="heroicons:arrow-trending-down-20-solid"
                                class="w-3 h-3 mr-1"></iconify-icon>
                        @endif
                        {{ $trendValue }}%
                    </div>
                @endif
            </div>
        </div>

        <div class="flex-shrink-0">
            <div
                class="w-12 h-12 bg-{{ $color }}-100 dark:bg-{{ $color }}-900/50 rounded-xl flex items-center justify-center">
                {{-- {!! $icon !!} --}}
                <iconify-icon icon="{{ $icon }}" width="20" height="20"
                    class="w-6 h-6 flex items-center justify-center text-{{ $color }}-500 dark:text-{{ $color }}-400"></iconify-icon>
            </div>
        </div>
    </div>
</div>
