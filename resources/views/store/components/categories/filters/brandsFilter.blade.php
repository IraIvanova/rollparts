<div id="brator_wc_layered_nav-2" class="brator-sidebar-single-item woocommerce brator_widget_layered_nav">
    <div class="shop-sidebar-title"><h2>Brand</h2></div>
    <div class="brator-filter-item-content">
        <ul>
            @foreach($brands as $brand)
            <li class="wc-layered-nav-term"><a
                    href="#">{{$brand['name']}}</a><span
                    class="count"></span></li>
                @endforeach
        </ul>
    </div>
</div>
