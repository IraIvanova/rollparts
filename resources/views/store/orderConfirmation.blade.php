@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5 order-confirmation">
        <h1>Thank You for Your Order!</h1>
        <h4 class="mt-5 mb-3">Your order number is: #{{ session('orderId') }}</h4>
        <p>We are processing your order. You'll receive a confirmation email soon. Or you can check your order in your <a href="#">Account</a></p>

        <a href="{{ url('/') }}">Go to Homepage</a>
    </section>
@endsection
