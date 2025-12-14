<div class="space-y-4">
    @if($thumbnail)
        <div class="flex justify-center">
            <img 
                src="{{ asset('storage/' . $thumbnail) }}" 
                alt="{{ $title }}"
                class="max-w-full h-auto rounded-lg shadow-lg"
                style="max-height: 500px;"
            >
        </div>
        <div class="text-center text-sm text-gray-500">
            {{ $title }}
        </div>
    @else
        <div class="text-center text-gray-500">
            Tidak ada thumbnail
        </div>
    @endif
</div>