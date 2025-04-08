@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.refund') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.refund') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.refund.text') !!}
    </section>
@endsection
