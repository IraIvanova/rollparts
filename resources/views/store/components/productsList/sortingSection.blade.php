<div class="brator-inline-product-filter-area">
    <div class="brator-inline-product-filter-left">
        <div class="brator-filter-show-result">
            <p class="woocommerce-result-count">
                <span> Total {{$products->total()}}</span>results</p>
        </div>
    </div>
    <div class="brator-inline-product-filter-right">
        <div class="brator-filter-short-by">
            <p>Sort by</p>
            <div class="brator-filter-show-items-count">
                <form class="woocommerce-ordering" method="get">
                    <select name="orderby" class="orderby" aria-label="Shop order">
                        <option value="menu_order" selected="selected">Default sorting</option>
                        <option value="popularity">Sort by popularity</option>
                        <option value="rating">Sort by average rating</option>
                        <option value="date">Sort by latest</option>
                        <option value="price">Sort by price: low to high</option>
                        <option value="price-desc">Sort by price: high to low</option>
                    </select>
                    <input type="hidden" name="paged" value="1">
                </form>
            </div>
        </div>
    </div>
</div>
