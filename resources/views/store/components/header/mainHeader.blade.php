<div class="rp-header-menu-area" id="main-menu">
    <div class="close-menu-bg"></div>

    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rp-header-menu-with-info">
                    <div class="rp-header-menu">
                        @include('store.components.header.menu')
                    </div>
                    <div class="rp-header-menu-info">
                        <span>{{ trans('interface.header.callUs') }}:</span>
                        <a href="tel:{{ $contacts['phone'] }}">{{ $contacts['phone'] }}</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
