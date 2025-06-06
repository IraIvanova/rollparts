@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.privacy') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.privacy') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.privacy.text') !!}
    </section>
@endsection
