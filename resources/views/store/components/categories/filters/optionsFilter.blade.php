@foreach($options as $label => $optionValues)
    <div id="brator_wc_layered_nav-3" class="brator-sidebar-single-item woocommerce brator_widget_layered_nav">
        <div class="shop-sidebar-title"><h2>{{$label}}</h2></div>
        <div class="brator-filter-item-content list">
            <ul>
                @foreach($optionValues as $value)
                    <li class="d-flex">
                        <input type="checkbox" class="checkbox" id="option{{$label . '-' . $value}}" name="option_{{$label}}" checked value="{{$value}}" />
                        <label class="filter-label" for="option{{$label . '-' . $value}}">{{$value}}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach

