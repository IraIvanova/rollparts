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
                                        <h2>{{ trans('interface.auth.register') }}</h2>
                                        <form class="woocommerce-form woocommerce-form-login login" action="{{ route('process-register') }}" method="post">
                                            <div class="@error('email') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="username">{{ trans('interface.form.email') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="username" required>
                                                 @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                 @enderror
                                            </div>
                                            <div class="@error('phone') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="phone">{{ trans('interface.form.phone') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="phone" required>
                                                @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="@error('name') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="name">{{ trans('interface.form.name') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="name" id="name" required>
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="@error('lastName') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="lastName">{{ trans('interface.form.lastName') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="lastName" id="lastName" required>
                                                @error('lastName')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="@error('password') error @enderror woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="password">{{ trans('interface.form.password') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" required>
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <label for="confirmPassword">{{ trans('interface.form.confirmPassword') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password_confirmation" id="confirmPassword" required>
                                            </div>
                                            <p class="form-row">
                                                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit">{{ trans('interface.buttons.register') }}</button>
                                            </p>
                                            @csrf
                                        </form>


                                    </div>

                                    <div class="col-6">

                                            <p>A link to set a new password will be sent to your email address.</p>
                                            <p>A link to set a new password will be sent to your email address.</p>
                                            <p>A link to set a new password will be sent to your email address.</p>
                                            <p>A link to set a new password will be sent to your email address.</p>
                                            <p>A link to set a new password will be sent to your email address.</p>

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
