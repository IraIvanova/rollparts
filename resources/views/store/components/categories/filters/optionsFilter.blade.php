@foreach($options as $label => $optionValues)
    <div class="rollparts-sidebar-single-item">
        <div class="shop-sidebar-title"><h2>{{$label}}</h2></div>
        <div class="rollparts-filter-item-content list">
            <ul>
                @foreach($optionValues as $value)
                    <li class="d-flex">
                        <input type="checkbox" @if(isOptionShouldBeChecked($selectedOptions, $label, $value)) checked @endif class="checkbox" id="option{{$label . '-' . $value}}" name="option_{{$label}}" value="{{$value}}" />
                        <label class="filter-label" for="option{{$label . '-' . $value}}">{{$value}}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach

