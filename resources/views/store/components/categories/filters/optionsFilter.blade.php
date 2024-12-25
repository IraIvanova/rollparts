@foreach($options as $label => $optionValues)
    <div id="brator_wc_layered_nav-3" class="brator-sidebar-single-item woocommerce brator_widget_layered_nav">
        <div class="shop-sidebar-title"><h2>{{$label}}</h2></div>
        <div class="brator-filter-item-content">
            <ul>
                @foreach($optionValues as $value)
                <li class="wc-layered-nav-term">
                    <a
                        href="#">{{$value}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach

