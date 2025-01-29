@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5  .category-page">

        <div class="d-flex mt-3 align-items-center">
            <h3>{{ trans('interface.catalog.title') }}</h3>
            <span class="px-3"> - </span>
            <span>{{ trans('interface.catalog.searchResults') }} </span> <b>{{$search}}</b>
        </div>
        {{--TODO: ADD SEARCH STRING--}}
        <input type="hidden" id="cart-route" value="{{route('addToCart')}}" />
        <div>
            @include('store.components.breadcrumbs')
            {{--            @include('store.components.banner')--}}
            <div class="rollparts-product-shop-page-area">
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

@section('additionalScript')
    <script src="{{ asset('js/store/category.js') }}"></script>
@endsection
