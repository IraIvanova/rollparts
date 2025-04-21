@if ($colorVariants->isNotEmpty())
    <div class="mt-6">
        @if($product->color)
        <p>Color: <b>{{ $product->color->name }}</b></p>
        @endif
        <div class="flex gap-4">
            <a href="{{ route('product', $product->slug) }}" class="flex color-variant items-center selected mr-1 gap-2 p-2 border rounded hover:bg-gray-100">
                <div class="w-full aspect-square border rounded overflow-hidden">
                    <img
                        src="{{ getMainImagePath($product, 'thumb') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                        style="max-height: 70px"
                    />
                </div>
            </a>
            @foreach ($colorVariants as $variant)
                <a href="{{ route('product', $variant->slug) }}" class="flex items-center mr-1 gap-2 p-2 border rounded hover:bg-gray-100">
                    <div class="w-full aspect-square border rounded overflow-hidden">
                        <img
                            src="{{ getMainImagePath($variant, 'thumb') }}"
                            alt="{{ $variant->name }}"
                            class="w-full h-full object-cover"
                            style="max-height: 70px"
                        />
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
