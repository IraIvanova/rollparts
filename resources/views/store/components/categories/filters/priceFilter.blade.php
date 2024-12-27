<div id="woocommerce_price_filter-2" class="brator-sidebar-single-item woocommerce widget_price_filter">
    <div class="shop-sidebar-title"><h2>Price</h2></div>
{{--    <form method="get" action="https://brator-main.smartdemowp.com/product-category/wheels-tires/">--}}
        <div class="price_slider_wrapper">
            <div class="price_slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                 style="">
                <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span
                    tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
            </div>
            <div class="price_slider_amount" data-step="10">
                <label class="screen-reader-text" for="min_price">Min price</label>
                <input type="text" id="min_price" name="min_price" value="10" data-min="10" placeholder="Min price"
                       style="display: none;">
                <label class="screen-reader-text" for="max_price">Max price</label>
                <input type="text" id="max_price" name="max_price" value="50" data-max="50" placeholder="Max price"
                       style="display: none;">
                <button type="submit" class="button">Filter</button>
                <div class="price_label" style="">
                    Price: <span class="from">$10</span> — <span class="to">$50</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
{{--    </form>--}}

</div>
