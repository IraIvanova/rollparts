@if(!empty($recentlyViewedProducts))
    <div class="recently-view">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-12">
                    <div class="rp-section-header">
                        <div class="rp-section-header-title">
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
