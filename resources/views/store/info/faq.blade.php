@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.faq') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.faq') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.faq.text') !!}
    </section>
@endsection
