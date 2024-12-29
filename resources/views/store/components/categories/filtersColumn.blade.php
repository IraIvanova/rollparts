<div class="brator-sidebar-area design-one filters">
    <div class="close-fillter">
        <svg class="bi bi-x" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
        </svg>
    </div>
    <form action="{{ isset($category) ? route('catalog', $category['slug']) : route('catalog')}}" id="filters-form">
    @include('store.components.categories.filters.categoriesList', ['selectedCategory' => $category ?? null])
    @include('store.components.categories.filters.priceFilter')
    @include('store.components.categories.filters.brandsFilter')
    @include('store.components.categories.filters.optionsFilter')


{{--        <input type="hidden" name="prices">--}}
{{--        <input type="hidden" name="brands">--}}
{{--        <input type="hidden" name="options">--}}
{{--        <input type="submit" class="d-none">--}}
    </form>
</div>

