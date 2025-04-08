@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.account') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.account') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.aboutUs.text') !!}
    </section>
@endsection
