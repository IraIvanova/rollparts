<div class="rp-sidebar-single-item">
    <div class="shop-sidebar-title"><h2>{{ trans('interface.filtersAndSort.brands') }}</h2></div>
    <div class="rp-filter-item-content list">
        <ul>
            @foreach($brands as $brand)
                <li class="d-flex">
                    <input type="checkbox" class="checkbox" @if(in_array($brand['name'], $selectedOptions['carMakes'])) checked @endif id="carMake{{$brand['id']}}" name="carMakes" value="{{$brand['name']}}" />
                    <label class="filter-label" for="carMake{{$brand['id']}}">{{$brand['name']}}</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
