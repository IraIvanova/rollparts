<div class="rollparts-sidebar-single-item">
    <div class="shop-sidebar-title"><h2>{{ trans('interface.filtersAndSort.brands') }}</h2></div>
    <div class="rollparts-filter-item-content list">
        <ul>
            @foreach($brands as $brand)
                <li class="d-flex">
                    <input type="checkbox" class="checkbox" @if(in_array($brand['name'], $selectedOptions['brands'])) checked @endif id="brand{{$brand['id']}}" name="brands" value="{{$brand['name']}}" />
                    <label class="filter-label" for="brand{{$brand['id']}}">{{$brand['name']}}</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
