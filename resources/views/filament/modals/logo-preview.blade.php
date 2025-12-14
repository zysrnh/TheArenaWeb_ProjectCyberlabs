<div class="p-4">
    @if($logo)
        <div class="text-center">
            <h3 class="text-lg font-semibold mb-4">{{ $name }}</h3>
            <img src="{{ Storage::url($logo) }}" 
                 alt="Logo {{ $name }}" 
                 class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                 style="max-height: 500px;">
        </div>
    @else
        <div class="text-center text-gray-500">
            <p>Logo tidak tersedia</p>
        </div>
    @endif
</div>