@if(!empty($frequentlyBoughtTogetherProducts))
<div class="recently-view">
    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-12">
                <div class="rp-section-header">
                    <div class="rp-section-header-title">
                        <h2>Frequently bought together</h2>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="product-list-items ">
                    @foreach ($frequentlyBoughtTogetherProducts as $fProduct)
                        @include('store.components.productsList.item2', ['product' => $fProduct, 'images' => $images ])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
