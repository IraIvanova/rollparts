@extends('store.base')

@section('bodyContent')
    <section class="rollparts-cont ">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        <div class="page-content">
                            <div class="woocommerce"><div class="woocommerce-notices-wrapper"></div>

                                <div class="row" id="customer_login">

                                    <div class="col-lg-6 col-md-12">
                                        <h2>{{ trans('interface.auth.register') }}</h2>
                                        <form class="woocommerce-form of-form-login login" action="{{ route('process-register') }}" method="post">
                                            <div class="@error('email') error @enderror   form-row form-row-wide">
                                                <label for="username">{{ trans('interface.form.email') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="email" class="of-Input  input-text" name="email" id="username" required>
                                                 @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                 @enderror
                                            </div>
                                            <div class="@error('phone') error @enderror   form-row form-row-wide">
                                                <label for="phone">{{ trans('interface.form.phone') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="tel" class="of-Input  input-text" name="phone" id="phone" required>
                                                @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="@error('name') error @enderror   form-row form-row-wide">
                                                <label for="name">{{ trans('interface.form.name') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="of-Input  input-text" name="name" id="name" required>
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="@error('lastName') error @enderror   form-row form-row-wide">
                                                <label for="lastName">{{ trans('interface.form.lastName') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="of-Input  input-text" name="lastName" id="lastName" required>
                                                @error('lastName')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="@error('password') error @enderror   form-row form-row-wide">
                                                <label for="password">{{ trans('interface.form.password') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input class="of-Input  input-text" type="password" name="password" id="password" required>
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="  form-row form-row-wide">
                                                <label for="confirmPassword">{{ trans('interface.form.confirmPassword') }}<span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input class="of-Input  input-text" type="password" name="password_confirmation" id="confirmPassword" required>
                                            </div>
                                            <p class="form-row">
                                                <button type="submit" class=" button of-form-login__submit">{{ trans('interface.buttons.register') }}</button>
                                            </p>
                                            @csrf
                                        </form>


                                    </div>

                                    <div class="col-lg-6 col-md-12">

                                        <ul class="p-0">
                                            <li><p><b>{{ trans('interface.auth.advantage_1') }}:</b>{{ trans('interface.auth.advantage_1_1') }}</p></li>
                                            <li><p><b>{{ trans('interface.auth.advantage_2') }}:</b>{{ trans('interface.auth.advantage_2_1') }}</p></li>
                                            <li><p><b>{{ trans('interface.auth.advantage_3') }}:</b>{{ trans('interface.auth.advantage_3_1') }}</p></li>
                                        </ul>

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
