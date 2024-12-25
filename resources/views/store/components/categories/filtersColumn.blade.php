<div class="brator-sidebar-area design-one">
    <div class="close-fillter">
        <svg class="bi bi-x" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
        </svg>
    </div>
    <div id="woocommerce_product_categories-2" class="brator-sidebar-single-item woocommerce widget_product_categories">
        <div class="shop-sidebar-title"><h2>Categories</h2>
        </div>
        @include('store.components.categories.filters.categoriesList', ['selectedCategory' => $category])
        {{--            <ul class="product-categories shop-cat-list"><li class="cat-item cat-item-31"><a href="https://brator-main.smartdemowp.com/product-category/air-filters/">Air Filters</a></li>--}}
        {{--                <li class="cat-item cat-item-34 cat-parent sub-cat"><a href="https://brator-main.smartdemowp.com/product-category/auto-parts/">Auto Parts</a><ul class="children">--}}
        {{--                        <li class="cat-item cat-item-54 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/auto-parts/caliper-covers/">Caliper Covers</a></li>--}}
        {{--                        <li class="cat-item cat-item-52 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/auto-parts/tire-chains/">Tire Chains</a></li>--}}
        {{--                        <li class="cat-item cat-item-49 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/auto-parts/wheels-cover/">Wheels Cover</a></li>--}}
        {{--                    </ul>--}}
        {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg></li>--}}
        {{--                <li class="cat-item cat-item-63"><a href="https://brator-main.smartdemowp.com/product-category/car-care/">Car Care</a></li>--}}
        {{--                <li class="cat-item cat-item-67"><a href="https://brator-main.smartdemowp.com/product-category/clearance/">Clearance</a></li>--}}
        {{--                <li class="cat-item cat-item-106"><a href="https://brator-main.smartdemowp.com/product-category/entertaiments/">Entertaiments</a></li>--}}
        {{--                <li class="cat-item cat-item-107"><a href="https://brator-main.smartdemowp.com/product-category/exhaust-system/">Exhaust System</a></li>--}}
        {{--                <li class="cat-item cat-item-36"><a href="https://brator-main.smartdemowp.com/product-category/exteriors/">Exteriors</a></li>--}}
        {{--                <li class="cat-item cat-item-64"><a href="https://brator-main.smartdemowp.com/product-category/fluids-chemicals/">Fluids &amp; Chemicals</a></li>--}}
        {{--                <li class="cat-item cat-item-105"><a href="https://brator-main.smartdemowp.com/product-category/interiors/">Interiors</a></li>--}}
        {{--                <li class="cat-item cat-item-38"><a href="https://brator-main.smartdemowp.com/product-category/performance/">Performance</a></li>--}}
        {{--                <li class="cat-item cat-item-41"><a href="https://brator-main.smartdemowp.com/product-category/sanex/">sanex</a></li>--}}
        {{--                <li class="cat-item cat-item-37 cat-parent sub-cat"><a href="https://brator-main.smartdemowp.com/product-category/starting-charging/">Starting &amp; Charging</a><ul class="children">--}}
        {{--                        <li class="cat-item cat-item-53 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/starting-charging/lug-nuts-locks/">Lug Nuts &amp; Locks</a></li>--}}
        {{--                        <li class="cat-item cat-item-51 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/starting-charging/tpms-sensors/">TPMS Sensors</a></li>--}}
        {{--                    </ul>--}}
        {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg></li>--}}
        {{--                <li class="cat-item cat-item-102"><a href="https://brator-main.smartdemowp.com/product-category/tire-pressure-gauges-2/">Tire Pressure Gauges</a></li>--}}
        {{--                <li class="cat-item cat-item-59"><a href="https://brator-main.smartdemowp.com/product-category/tires-chains/">Tires Chains</a></li>--}}
        {{--                <li class="cat-item cat-item-65"><a href="https://brator-main.smartdemowp.com/product-category/tools-supplies/">Tools &amp; Supplies</a></li>--}}
        {{--                <li class="cat-item cat-item-15"><a href="https://brator-main.smartdemowp.com/product-category/uncategorized/">Uncategorized</a></li>--}}
        {{--                <li class="cat-item cat-item-32 current-cat cat-parent sub-cat"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/">Wheels &amp; Tires</a><ul class="children">--}}
        {{--                        <li class="cat-item cat-item-58 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/accessories/">Accessories</a></li>--}}
        {{--                        <li class="cat-item cat-item-55 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/custom-wheels/">Custom Wheels</a></li>--}}
        {{--                        <li class="cat-item cat-item-40 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/factory-wheels/">Factory Wheels</a></li>--}}
        {{--                        <li class="cat-item cat-item-50 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/packages/">Packages</a></li>--}}
        {{--                        <li class="cat-item cat-item-57 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/tire-pressure-gauges/">Tire Pressure Gauges</a></li>--}}
        {{--                        <li class="cat-item cat-item-48 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/tires/">Tires</a></li>--}}
        {{--                        <li class="cat-item cat-item-56 sub-cat2"><a href="https://brator-main.smartdemowp.com/product-category/wheels-tires/wheel-adapters/">Wheel Adapters</a></li>--}}
        {{--                    </ul>--}}
        {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg></li>--}}
        {{--                <li class="cat-item cat-item-109"><a href="https://brator-main.smartdemowp.com/product-category/wipers-washers/">Wipers &amp; Washers</a></li>--}}
        {{--            </ul>--}}
    </div>

    @include('store.components.categories.filters.priceFilter')
    @include('store.components.categories.filters.brandsFilter', $brands)
    @include('store.components.categories.filters.optionsFilter', $options)



</div>

