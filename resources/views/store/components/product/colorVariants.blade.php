@if ($colorVariants->isNotEmpty())
    <div class="mt-6">
        @if($product->color)
        <p>Color: <b>{{ $product->color->name }}</b></p>
        @endif
        <div class="flex gap-4">
            <a href="{{ route('product', $product->slug) }}" class="flex items-center gap-2 p-2 border rounded hover:bg-gray-100 chosen">
                <div class="w-full aspect-square border rounded overflow-hidden">
                    <img
                        {{--                            src="{{ $variant->getFirstMediaUrl('products') ?? asset('images/default.png') }}"--}}
                        src="{{ asset('images/default.png') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                        style="max-height: 70px"
                    />
                </div>
            </a>
            @foreach ($colorVariants as $variant)
                <a href="{{ route('product', $variant->slug) }}" class="flex items-center gap-2 p-2 border rounded hover:bg-gray-100">
                    <div class="w-full aspect-square border rounded overflow-hidden">
                        <img
{{--                            src="{{ $variant->getFirstMediaUrl('products') ?? asset('images/default.png') }}"--}}
                            src="{{ asset('images/default.png') }}"
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
