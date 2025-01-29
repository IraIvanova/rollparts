@if(!empty($recentlyViewedProducts))
    <div class="recently-view woocommerce">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-12">
                    <div class="rollparts-section-header">
                        <div class="rollparts-section-header-title">
                            <h2>Recently Viewed</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="product-list-items ">
                        @foreach ($recentlyViewedProducts as $rProduct)
                            @include('store.components.productsList.item2', ['product' => $rProduct, 'images' => $images ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
