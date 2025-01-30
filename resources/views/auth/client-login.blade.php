@extends('store.base')

@section('bodyContent')
    <section class="rp-cont ">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        <div class="page-content">
                            <div class="row" id="customer_login">
                                <div class="col-lg-6 col-md-12">
                                    <h2>{{ trans('interface.auth.login') }}</h2>
                                    <form class="rp-form rp-form-login login" method="post"
                                          action="{{ route('process-login') }}">
                                        <p class="rp-form-row rp-form-row--wide form-row form-row-wide">
                                            <label for="username">{{ trans('interface.form.email') }}<span
                                                    class="required" aria-hidden="true">*</span>
                                            </label>
                                            <input type="text" class="rp-form-row-Input input-text" name="email"
                                                   id="username" autocomplete="username" value="" required=""
                                                   aria-required="true">
                                        </p>
                                        <p class="rp-form-row rp-form-row--wide form-row form-row-wide">
                                            <label for="password">{{ trans('interface.form.password') }}<span
                                                    class="required" aria-hidden="true">*</span>
                                            </label>
                                            <input class="rp-form-row-Input  input-text" type="password" name="password"
                                                   id="password" autocomplete="current-password" required=""
                                                   aria-required="true">
                                        </p>


                                        <p class="form-row">
                                            <button type="submit" class="button rp-form-login__submit" name="login"
                                                    value="Log in">{{ trans('interface.buttons.login') }}</button>

                                            <label
                                                class="rp-form__label rp-form__label-for-checkbox rp-form-login__rememberme">
                                                <input class="rp-form__input rp-form__input-checkbox" name="rememberme"
                                                       type="checkbox" id="rememberme" value="forever">
                                                <span>{{ trans('interface.auth.rememberMe') }}</span>
                                            </label>
                                        </p>
                                        <p class="lost_password">
                                            <a href="">{{ trans('interface.auth.lostYourPassword') }}</a>
                                        </p>
                                        @csrf
                                    </form>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <h2>{{ trans('interface.auth.register') }}</h2>
                                    <ul class="p-0">
                                        <li><p><b>{{ trans('interface.auth.advantage_1') }}:</b>{{ trans('interface.auth.advantage_1_1') }}</p></li>
                                        <li><p><b>{{ trans('interface.auth.advantage_2') }}:</b>{{ trans('interface.auth.advantage_2_1') }}</p></li>
                                        <li><p><b>{{ trans('interface.auth.advantage_3') }}:</b>{{ trans('interface.auth.advantage_3_1') }}</p></li>
                                    </ul>
                                    <p class="rp-form-row rp-form-row--wide form-row form-row-wide">
                                        <a class="button rp-form-register__submit"
                                           href="{{route('register')}}">{{ trans('interface.buttons.register') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
