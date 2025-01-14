@extends('store.base')

@section('bodyContent')
    <section class="brator-blog-post-area ">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        <div class="page-content">
                            <div class="woocommerce"><div class="woocommerce-notices-wrapper"></div>

                                <div class="row" id="customer_login">

                                    <div class="col-6">


                                        <h2>{{ trans('interface.auth.login') }}</h2>

                                        <form class="woocommerce-form woocommerce-form-login login" method="post" action="{{ route('process-login') }}">


                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="username">{{ trans('interface.form.email') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="username" autocomplete="username" value="" required="" aria-required="true">
                                            </p>
                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="password">{{ trans('interface.form.password') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required="" aria-required="true">
                                            </p>


                                            <p class="form-row">
                                                <input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="0f2c0256ce"><input type="hidden" name="_wp_http_referer" value="/my-account/">
                                                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="Log in">{{ trans('interface.buttons.login') }}</button>

                                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>{{ trans('interface.auth.rememberMe') }}</span>
                                                </label>
                                                 </p>
                                            <p class="woocommerce-LostPassword lost_password">
                                                <a href="">{{ trans('interface.auth.lostYourPassword') }}</a>
                                            </p>
                                            @csrf

                                        </form>


                                    </div>

                                    <div class="col-6">

                                        <h2>{{ trans('interface.auth.register') }}</h2>


                                            <p>A link to set a new password will be sent to your email address.</p>

                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <a class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" href="{{route('register')}}">{{ trans('interface.buttons.register') }}</a>
                                            </p>


                                    </div>

                                </div>

                            </div></div>
                        <div class="row">
                            <div class="col-lg-10 col-sm-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
