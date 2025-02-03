<div class="rp-sidebar-single-item widget_price_filter">
    <div class="priceTitle"><h2>{{ trans('interface.filtersAndSort.prices') }}</h2></div>
        <div class="price_slider_wrapper">
            <div class="price-input">
                <div class="field d-flex flex-column">
                    <p>{{ trans('interface.filtersAndSort.min') }}</p>
                    <input type="number" class="inputs input-min" value="{{ $selectedOptions['min'] ?? $prices[0] }}">
                </div>
                <div class="separator"></div>
                <div class="field d-flex flex-column">
                    <p>{{ trans('interface.filtersAndSort.max') }}</p>
                    <input type="number" class="inputs input-max" value="{{ $selectedOptions['max'] ?? $prices[1] }}">
                </div>
            </div>
            <div class="slider">
                <div class="progress"></div>
            </div>
            <div class="range-input">
                <input type="range" class="range-inputs range-min" min="23" max="966" value="{{ $selectedOptions['min'] ?? $prices[0] }}" step="1">
                <input type="range" class="range-inputs range-max" min="23" max="966" value="{{ $selectedOptions['max'] ?? $prices[1] }}" step="1">
            </div>
            <button type="button" id="pf-button" class="button price-filter-button button-fill-one mt-3">Filter</button>
        </div>
</div>
