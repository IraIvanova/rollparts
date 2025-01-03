@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
        <h3>Catalog & Search</h3>
        {{--TODO: ADD SEARCH STRING--}}
        <input type="hidden" id="cart-route" value="{{route('addToCart')}}" />
        <div>
            @include('store.components.breadcrumbs')
            {{--            @include('store.components.banner')--}}
            <div class="brator-product-shop-page-area">
                <div class="container-xxxl container">
                    <div class="row">
                        <div class="col-lg-3">
                            @include('store.components.categories.filtersColumn')
                        </div>
                        <div class="col-lg-9">
                            @include('store.components.productsList.sortingSection')
                            <div class="products columns-4">
                                <div class="product-list-items ">
                                    @foreach ($products as $product)
                                        @include('store.components.productsList.item', ['product' => $product, 'images' => $images])
                                    @endforeach
                                </div>
                                <div>
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
