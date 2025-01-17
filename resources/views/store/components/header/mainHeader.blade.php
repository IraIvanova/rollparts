<div class="brator-header-menu-area" id="main-menu">
    <div class="close-menu-bg"></div>

    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brator-header-menu-with-info">
                    <div class="brator-header-menu">
                        @include('store.components.header.menu')
                    </div>
                    <div class="brator-header-menu-info">
                        <a href="https://brator-main.smartdemowp.com/order-track/">Track Order</a>
                        <span>{{ trans('interface.header.callUs') }}:</span>
                        <a href="tel:{{ $contacts['phone'] }}">{{ $contacts['phone'] }}</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
