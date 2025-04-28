@extends('store.base')

@section('metaTitle'){{ $name }} | {{ trans('interface.turkey') }} @endsection
@section('metaDescription'){{ trans('interface.meta.description.product', ['product' => $name, 'brand' => $brand->first()?->name]) }}@endsection

@section('bodyContent')
    <section id="main-content" >
        <div class="grey-bg">
            <div class="container container-xxxl">
        @include('store.components.breadcrumbs')
        <div class="product type-product">

            <div class="rp-product-header-layout-area desing-one">
                <div class="container-xxxl container-xxl container">
                    <div class="row">
                        <div class="rp-product-header-layout w-100">
                            <div class="rp-product-header-layout-img">
                                @include('store.components.imagesGallery')
                            </div>
                            <div class="rp-product-layout-header-content">
                                <div class="rp-product-hero-content">
                                    <div class="rp-product-hero-content-info">
                                        <div class="rp-product-hero-content-title">
                                            <a class="font-weight-bold text-primary">{{$product->manufacturer?->name}}</a>
                                            <h1>{{ $name }}</h1>
                                        </div>
                                        @if($prices['discount_amount'])
                                            <div class="rp-product-hero-content-review">
                                                <div
                                                    class="product-batch off-batch">{{ trans('interface.product.discountAmount', ['amount' => $prices['discount_amount']]) }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="rp-product-hero-content-price">
                                            <h6>
                                                @if((float)$prices['discount_amount'])
                                                        <span class="rp-Price-amount amount color-red"><span
                                                                        class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $prices['discounted_price'] }}</span>
                                                      <span class="rp-Price-amount amount px-2 color-grey line-through font-size-20px"><span
                                                                        class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $prices['price'] }}</span>
                                                @else
                                                    <span class="rp-Price-amount amount"><span
                                                            class="rp-currencySymbol">{{ trans('interface.trLira') }}</span>{{ $prices['price'] }}</span>
                                                @endif
                                            </h6>
                                            <div class="d-flex flex-column border-red width-fit-content mt-3">
                                                <div class="px-2 py-1 batch-primary">{{ trans('interface.product.bankTransferDiscount') }}</div>
                                                <div class="rp-Price-amount amount color-red text-center">{{ trans('interface.trLira') }} {{ number_format($prices['discounted_price'] - $prices['discounted_price'] * 0.05, 2) }}</div>
                                            </div>
                                        </div>
                                        @include('store.components.product.colorVariants')
                                        <div>
                                            <h6 class="font-size-14px my-2 pb-2 border-bottom">
                                                @if($active && $quantity)
                                                    <span class="status-circle active-status"></span>
                                                    <span class="stock pl-3">{{ trans('interface.product.qntInStock', ['qnt' => $quantity]) }}</span>
                                                @else
                                                    <span class="status-circle passive-status"></span>
                                                    <span class="pl-3">{{ trans('interface.product.outOfStock') }}</span>
                                                @endif
                                            </h6>
                                        </div>
                                        @include('store.components.product.relatedOptions')
                                        <div class="">
                                            <p>{{ trans('interface.product.mnfCode') }}: <b>{{ $mnfCode }}</b></p>
                                        </div>
                                    </div>
                                    <div class="rp-product-hero-content-add-to-cart">

                                            <div class="rp-product-single-cart-count-add">
                                                <div class="quantity rp-product-single-cart-count">

                                                    <div
                                                        class="item-quantity tt-input-counter js-counter rp-cart-list-items-qty">
                                                        <span class="minus-btn amount-btn">–</span>
                                                        <input type="number" id="quantity"
                                                               class="input-text qty text" name="quantity" value="1"
                                                               aria-label="Product quantity" size="4" min="1" max="1000"
                                                               step="1" placeholder="" inputmode="numeric"
                                                               autocomplete="off" >
                                                        <span class="plus-btn amount-btn">+</span>
                                                    </div>
                                                </div>
                                                <div class="rp-product-single-cart-add">
                                                    <input type="hidden" value="{{route('addToCart')}}" id="add-route" />

                                                    <button type="button" name="add-to-cart" id="addToCart" @if($quantity === 0) disabled @endif
                                                            class="button alt" data-product="{{$id}}"> {{ trans($quantity === 0 ? 'interface.buttons.productIsOutOfStock' :'interface.buttons.addToCart') }}
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                    @include('store.components.product.compatibleModels')
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
            <div class="rp-product-single-tab-area">
                <div class="container-xxxl container-xxl container">
                    <div class="row">
                        <div class="col-xxl-8 col-md-12">
                            <div class="rp-product-single-tab-list js-tabs " id="tabs-product-content">
                                <div class="rp-product-single-tab-header js-tabs__header">
                                    <ul>
                                        <li><a class="js-tabs__title js-tabs__title-active" href="#" data-index="0">Description</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-tabs__content rp-product-single-tab-item" style="">

                                    <div class="product-description mb-3">
                                        {!! $description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="mb-5">
        @include('store.components.productsSet.frequentlyBoughtTogetherProducts')
        @include('store.components.productsSet.recentlyViewedProducts')
</div>
    </section>
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/slick.min.js') }}"></script>
    <script src="{{ asset('js/store/fslightbox.js') }}"></script>
<script src="{{asset('js/store/product.js')}}"></script>
@endsection
