@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.orderConfirmation') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.orderConfirmation') }}@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 order-confirmation">
        <h1>{{ trans('interface.orderConfirmation.thanks') }}</h1>
        <h4 class="mt-5 mb-3">{{ trans('interface.orderConfirmation.number') }}: #{{ session('orderId') }}</h4>
        <p>{{ trans('interface.orderConfirmation.description', ['account_link' => route('client.account')]) }}</p>

        <a href="{{ url('/') }}">{{ trans('interface.orderConfirmation.backButton') }}</a>
    </section>
@endsection
