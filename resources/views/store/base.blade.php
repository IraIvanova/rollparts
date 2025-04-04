<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <title>@yield('metaTitle')</title>
    <meta name="description" content="@yield('metaDescription')">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">

    <link rel="stylesheet" media="all" href="{{asset('css/store/bootstrap.min.css')}}">
    <link rel="stylesheet" media="all" href="{{asset('css/store/styles.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/store/slick.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('css/store/slick-theme.css')}}"/>

    <script src="{{ asset('js/store/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/store/bootstrap.min.js') }}"></script>

<body class="page-template page">
<div class="page-wrapper">
    <input type="hidden" id="cart-route" value="{{route('addToCart')}}"/>
    @include('store.components.header.header')
    @yield('bodyContent')
    <div class="footer-block">
        <div class="container-xxxl container-xxl container">
            <div>
                <section class="rp-section">
                    <div class="section-container ">
                        <div class="section-column section-col-25  col-xl-4 col-lg-6">
                            <div>
                                <div>
                                    <div>
                                        <div class="rp-footer-top-element rp-footer-top-address">
                                            <h6 class="footer-top-title">{{ trans('interface.footer.contactUs') }}</h6>
                                            <div class="rp-footer-top-content">
                                                <p>{{ trans('interface.footer.workingHours', ['hours' => $contacts['workingHours']]) }}</p>
                                                <a class="call-top-p"
                                                   href="tel:{{ $contacts['phone'] }}">{{ $contacts['phone'] }}</a>
                                                <p>{{ $contacts['address'] }}</p>
                                                <a class="e-mail-to"
                                                   href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="section-column section-col-25   col-xl-2 col-lg-6">
                            <div>
                                <div>
                                    <div>
                                        <div class="rp-footer-top-element">
                                            <h6 class="footer-top-title">{{ trans('interface.footer.customerService') }}</h6>
                                            <div class="rp-footer-top-content rp-link-list-one">
                                                <ul>
                                                    <li class="link_with_normal">
                                                        <a href="{{ route('client.account') }}">
                                                            {{ trans('interface.footer.myAccount') }}</a>
                                                    </li>
                                                    <li class="link_with_normal">
                                                        <a href="{{ route('infoReturnPolicy') }}">
                                                            {{ trans('interface.footer.returnPolicy') }}</a>
                                                    </li>
                                                    <li class="link_with_normal">
                                                        <a href="{{ route('infoFaq') }}">
                                                            {{ trans('interface.footer.faq') }} </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="section-column section-col-25   col-xxl-3 col-xl-2 col-lg-6">
                            <div>
                                <div>
                                    <div>
                                        <div class="rp-footer-top-element">
                                            <h6 class="footer-top-title">{{ trans('interface.footer.information') }}</h6>
                                            <div class="rp-footer-top-content rp-link-list-one">
                                                <ul>
                                                    <li class="link_with_normal">
                                                        <a href="{{ route('infoAboutUs') }}">
                                                            {{ trans('interface.footer.about') }}</a>
                                                    </li>
                                                    <li class="link_with_normal">
                                                        <a href="{{ route('infoContactUs') }}">
                                                            {{ trans('interface.footer.contactUs') }} </a>
                                                    </li>
                                                    <li class="link_with_normal">
                                                        <a href="{{route('infoPrivacy')}}">
                                                            {{ trans('interface.footer.privacy') }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="section-column section-col-25   col-xl-3 col-lg-6">
                            <div>
                                <div>
                                    <div>
                                        <div class="rp-footer-top-element">
                                            <h6 class="footer-top-title">Subscribe To Our Newsletter</h6>
                                            <div class="rp-footer-top-content">
                                                <p>Register now to get latest updates on promotions &amp; coupons. Don’t
                                                    worry, we not spam!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <footer class="rp-footer-area">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rp-copyright-area">
                        <p> {{ trans('interface.footer.copyright', ['year' => 2025]) }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">

                </div>
                <div class="col-lg-4 col-12">
                    <div class="rp-social-link svg-link">
                        <h6 class="rp-social-link">{{ trans('interface.footer.followUs') }}</h6>
                        <a href="https://twitter.com/">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64">
                                <path
                                    d="M56.9,14.8l3.9-4.9C62,8.6,62.3,7.6,62.4,7c-3,1.9-5.9,2.5-7.9,2.5h-0.8L53.2,9c-2.5-2.2-5.5-3.4-8.9-3.4c-7.2,0-13,5.9-13,13c0,0.5,0,1,0.1,1.5l0.3,2.1l-2.2-0.1C16.3,21.8,5.5,10.5,3.7,8.5c-2.9,5.3-1.3,10.2,0.5,13.3l3.5,5.8l-5.5-3c0.1,4.3,1.8,7.7,4.9,10.2l2.7,2L7,37.9c1.8,5.3,5.6,7.4,8.6,8.3l3.8,1l-3.3,2.3c-5.7,4-13,3.8-16.1,3.5c6.6,4.5,14.2,5.5,19.7,5.5c4,0,7-0.5,7.7-0.7c29-6.8,30.3-32.6,30.2-37.8v-0.8l0.6-0.5c3.5-3.3,5-5.1,5.8-6.1c-0.3,0.2-0.7,0.3-1.2,0.4L56.9,14.8z"></path>
                            </svg>
                        </a>
                        <a href="http://facebbook.com/">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64">
                                <path
                                    d="M47.9,25.6L47.9,25.6h-5.8H40v-2.1v-6.4v-2.1h2.1h4.4c1.1,0,2-0.9,2-2V2c0-1.1-0.9-2-2-2h-7.6c-8.2,0-13.9,5.9-13.9,14.4v9.1v2.1h-2.1H16c-1.5,0-2.7,1.2-2.7,2.8v7.4c0,1.5,1.2,2.7,2.7,2.7h6.9h2.1v2.1v20.8c0,1.5,1.2,2.7,2.7,2.7h9.8c0.6,0,1.2-0.3,1.6-0.7c0.5-0.5,0.7-1.2,0.7-1.8l0,0v0V40.5v-2.1H42h4.6c1.3,0,2.4-0.9,2.6-2.1l0-0.1l0-0.1l1.4-7.1c0.2-0.8,0-1.6-0.6-2.4C49.6,26.1,48.8,25.7,47.9,25.6z"></path>
                            </svg>
                        </a>
                        <a href="https://youtube.com/">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64">
                                <path
                                    d="M62.7,16.6c-0.7-2.8-2.9-4.9-5.7-5.7c-5-1.3-25-1.3-25-1.3s-20,0-25,1.3c-2.8,0.7-4.9,2.9-5.7,5.7C0,21.6,0,32,0,32  s0,10.4,1.3,15.4c0.7,2.8,2.9,4.9,5.7,5.7c5,1.3,25,1.3,25,1.3s20,0,25-1.3c2.8-0.7,4.9-2.9,5.7-5.7C64,42.4,64,32,64,32  S64,21.6,62.7,16.6z M25.6,41.6V22.4L42.2,32L25.6,41.6z"></path>
                            </svg>
                        </a>
                        <a href="https://instagram.com/">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64"
                                 xml:space="preserve"><g>
                                    <path
                                        d="M62.9,19.2c-0.1-3.2-0.7-5.5-1.4-7.6S59.7,7.8,58,6.1s-3.4-2.7-5.4-3.5c-2-0.8-4.2-1.3-7.6-1.4C41.5,1,40.5,1,32,1s-9.4,0-12.8,0.1s-5.5,0.7-7.6,1.4S7.8,4.4,6.1,6.1s-2.8,3.4-3.5,5.5c-0.8,2-1.3,4.2-1.4,7.6S1,23.5,1,32s0,9.4,0.1,12.8c0.1,3.4,0.7,5.5,1.4,7.6c0.7,2.1,1.8,3.8,3.5,5.5s3.5,2.8,5.5,3.5c2,0.7,4.2,1.3,7.6,1.4C22.5,63,23.4,63,31.9,63s9.4,0,12.8-0.1s5.5-0.7,7.6-1.4c2.1-0.7,3.8-1.8,5.5-3.5s2.8-3.5,3.5-5.5c0.7-2,1.3-4.2,1.4-7.6c0.1-3.2,0.1-4.2,0.1-12.7S63,22.6,62.9,19.2zM57.3,44.5c-0.1,3-0.7,4.6-1.1,5.8c-0.6,1.4-1.3,2.5-2.4,3.5c-1.1,1.1-2.1,1.7-3.5,2.4c-1.1,0.4-2.7,1-5.8,1.1c-3.2,0-4.2,0-12.4,0s-9.3,0-12.5-0.1c-3-0.1-4.6-0.7-5.8-1.1c-1.4-0.6-2.5-1.3-3.5-2.4c-1.1-1.1-1.7-2.1-2.4-3.5c-0.4-1.1-1-2.7-1.1-5.8c0-3.1,0-4.1,0-12.4s0-9.3,0.1-12.5c0.1-3,0.7-4.6,1.1-5.8c0.6-1.4,1.3-2.5,2.3-3.5c1.1-1.1,2.1-1.7,3.5-2.3c1.1-0.4,2.7-1,5.8-1.1c3.2-0.1,4.2-0.1,12.5-0.1s9.3,0,12.5,0.1c3,0.1,4.6,0.7,5.8,1.1c1.4,0.6,2.5,1.3,3.5,2.3c1.1,1.1,1.7,2.1,2.4,3.5c0.4,1.1,1,2.7,1.1,5.8c0.1,3.2,0.1,4.2,0.1,12.5S57.4,41.3,57.3,44.5z"></path>
                                    <path
                                        d="M32,16.1c-8.9,0-15.9,7.2-15.9,15.9c0,8.9,7.2,15.9,15.9,15.9S48,40.9,48,32S40.9,16.1,32,16.1z M32,42.4c-5.8,0-10.4-4.7-10.4-10.4S26.3,21.6,32,21.6c5.8,0,10.4,4.6,10.4,10.4S37.8,42.4,32,42.4z"></path>
                                    <ellipse cx="48.7" cy="15.4" rx="3.7" ry="3.7"></ellipse>
                                </g></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <button class="scroll-top scroll-to-target" data-target="html">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
        </svg>
        <span>top</span>
    </button>
</div>
@include('store.modal.product-added-modal')
@include('store.modal.info-modal')
<script src="{{asset('js/store/axios.min.js')}}"></script>
<script src="{{asset('js/store/base.js')}}"></script>
<script src="{{asset('js/store/main.js')}}"></script>
@yield('additionalScript')
@include('cookie-consent::index')
</body>
</html>
