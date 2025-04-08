@extends('store.info.infoBase')

@section('metaTitle')
    {{ trans('interface.meta.title.contact') }}
@endsection
@section('metaDescription')
    {{ trans('interface.meta.description.contact') }}
@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 info-page">
        {!! trans('interface.contactPage.mainText') !!}
    </section>
@endsection
