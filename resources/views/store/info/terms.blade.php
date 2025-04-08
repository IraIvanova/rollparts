@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.tnc') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.tnc') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.tncPage.text') !!}
    </section>
@endsection
