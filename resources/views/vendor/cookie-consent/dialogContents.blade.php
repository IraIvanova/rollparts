<div class="js-cookie-consent cookie-consent fixed-bottom bg-white py-2">
    <div class="container">
        <div class="p-3 rounded-lg bg-white text-dark">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <b>{{ trans('interface.cookies.consent.title') }}</b>
                    <p class="mb-0 cookie-consent__message">
                        {!! trans('interface.cookies.consent.message', ['privacy_url' => route('infoPrivacy')]) !!}
                    </p>
                </div>
                <div class="mt-2 mt-sm-0">
                    <button class="js-cookie-consent-agree cookie-consent__agree btn btn-sm btn-dark">
                        {{ trans('interface.cookies.consent.button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
