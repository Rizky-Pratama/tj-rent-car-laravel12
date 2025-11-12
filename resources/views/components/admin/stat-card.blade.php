@props(['title', 'value', 'icon', 'color' => 'indigo', 'trend' => null, 'trendValue' => null])

<div
    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 dark:border-gray-700 p-5">
    <!-- Icon dan Title sejajar -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-3">
            <div
                class="w-11 h-11 bg-{{ $color }}-100 dark:bg-{{ $color }}-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                <iconify-icon icon="{{ $icon }}" width="20" height="20"
                    class="text-{{ $color }}-500 dark:text-{{ $color }}-400"></iconify-icon>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
        </div>

        @if ($trend && $trendValue)
            <div
                class="flex items-center text-xs font-medium px-1.5 py-0.5 rounded {{ $trend === 'up' ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20' : 'text-red-600 bg-red-50 dark:bg-red-900/20' }}">
                @if ($trend === 'up')
                    <iconify-icon icon="heroicons:arrow-trending-up-20-solid" class="w-3 h-3 mr-0.5"></iconify-icon>
                @else
                    <iconify-icon icon="heroicons:arrow-trending-down-20-solid" class="w-3 h-3 mr-0.5"></iconify-icon>
                @endif
                {{ $trendValue }}%
            </div>
        @endif
    </div>

    <!-- Value -->
    <div>
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
    </div>
</div>
