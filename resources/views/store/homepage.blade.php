@extends('store.base')

@section('metaTitle')
    {{ trans('interface.meta.title.home') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.home') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl">
        @include('store.components.homepage.gallery')


{{--        @include('store.components.homepage.homeTitle')--}}
    </section>
    @include('store.components.homepage.searchByModel')

    <section id="about-us" class="container container-xxxl">

        @include('store.components.homepage.services')
            @include('store.components.homepage.homeTitle')
    </section>
    @include('store.components.homepage.categories')

    <section class="container container-xxxl">
        @include('store.components.homepage.bestsellers')
    </section>

    @include('store.components.homepage.featuredBrands')
    @include('store.components.homepage.aboutUs')
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/slick.min.js') }}"></script>
    <script src="{{asset('js/store/homepage.js')}}"></script>
@endsection
