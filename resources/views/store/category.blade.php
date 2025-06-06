@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.category') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.category') }}@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl">
        <div>
            @include('store.components.breadcrumbs')
{{--            @include('store.components.banner')--}}
            <div class="rp-product-shop-page-area category-page">
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
                                        @include('store.components.productsList.item', ['product' => $product])
                                    @endforeach
                                </div>
                                <div>
{{--                                    @dd($products->links())--}}
                                    {{ $products->links('pagination::bootstrap-4') }}
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
