@if(!empty($productOptions))
    <span class="font-weight-bold mb-0 text-color-black">Available options:</span>
    <div class="optionValues border-bottom">
        @foreach($productOptions as $key => $optionValues)
            <p>{{$key}}</p>
            <div class="d-flex align-items-center mb-3">
            @foreach($optionValues as $optionValue)
                <a href="{{route('product', $optionValue[1])}}">{{$optionValue[0]}}</a>
            @endforeach
            </div>
        @endforeach
    </div>
@endif
