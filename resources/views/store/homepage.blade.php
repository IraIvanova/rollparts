@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
   @include('store.components.homepage.gallery')
   @include('store.components.homepage.services')
   @include('store.components.homepage.bestsellers')

    </section>
    @include('store.components.homepage.categories')
    @include('store.components.homepage.featuredBrands')
    @include('store.components.homepage.aboutUs')
@endsection

@section('additionalScript')
    <script src="{{ asset('js/store/slick.min.js') }}"></script>
    <script src="{{asset('js/store/homepage.js')}}"></script>
@endsection
