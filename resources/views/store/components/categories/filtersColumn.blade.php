<div class="rp-sidebar-area design-one filters">
    <div class="filter-header" id="filterHeader">
        <span>Filter Options</span>
        <span class="toggle-icon">&#9660;</span>
    </div>
    <div class="filter-content" id="filterContent">
    <form action="{{ isset($category) ? route('category', $category['slug']) : route('catalog')}}" id="filters-form">
    @include('store.components.categories.filters.categoriesList', ['selectedCategory' => $category ?? null])
    @include('store.components.categories.filters.priceFilter')
    @include('store.components.categories.filters.brandsFilter')
    @include('store.components.categories.filters.optionsFilter')
        <input name="carModels" id="carModelsValue" type="hidden" value="{{ implode(',', $selectedOptions['carModels']) }}">
    </form>
    </div>
</div>

