<div {{ $attributes->merge(['class' => 'flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100']) }}>
    <div class="w-full mt-6 overflow-hidden bg-white shadow-md sm:max-w-4xl sm:rounded-lg">
        @if (isset($title))
            <div class="py-3 bg-gray-50">
                <h2 class="text-3xl text-center text-gray-600">{{ $title }}</h2>
            </div>
        @endif
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
    </div>
</div>
