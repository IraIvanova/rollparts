
<div>
    @if(count($selectedProducts ?? []))
        <table class="table-auto w-full text-sm">
            <thead>
            <tr>
                <th class="px-2 py-1">Image</th>
                <th class="px-2 py-1">Name</th>
                <th class="px-2 py-1">Qty</th>
                <th class="px-2 py-1">Price</th>
                <th class="px-2 py-1">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($selectedProducts as $product)
                <tr>
                    <td></td>
                    <td class="border px-2 py-1">{{ $product->translationByLanguage->name }}</td>
                    <td class="border px-2 py-1">1</td>
                    <td class="border px-2 py-1">{{ $product->priceByCurrency->price }}</td>
                    <td class="border px-2 py-1">{{ $product->priceByCurrency->price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500 text-center py-4">No products selected</p>
    @endif
</div>
