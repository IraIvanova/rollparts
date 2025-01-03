<div class="brator-sidebar-area design-one filters">
    <div class="filter-header" id="filterHeader">
        <span>Filter Options</span>
        <span class="toggle-icon">&#9660;</span>
    </div>
    <div class="filter-content" id="filterContent">
    <form action="{{ isset($category) ? route('catalog', $category['slug']) : route('catalog')}}" id="filters-form">
    @include('store.components.categories.filters.categoriesList', ['selectedCategory' => $category ?? null])
    @include('store.components.categories.filters.priceFilter')
    @include('store.components.categories.filters.brandsFilter')
    @include('store.components.categories.filters.optionsFilter')
    </form>
    </div>
</div>

