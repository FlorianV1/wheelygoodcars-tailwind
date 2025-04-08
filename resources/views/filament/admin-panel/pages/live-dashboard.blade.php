<x-filament::page>
    <div wire:poll.10s>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($stats as $label => $value)
                <div class="rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>
