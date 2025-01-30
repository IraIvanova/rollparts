<section class="rp-section gray-bg">
    <div class="rp-categories-list-area rp-design">
        <div class="container-xxxl container-xxl container">
            <div class="row">
                <div class="col-md-12">
                    <div class="rp-section-header">
                        <div class="rp-section-header-title">
                            <h2>{{ trans('interface.home.shopByCategories') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 categories-slider">
                    @foreach($categories as $category)
                        @if(!$category['parent_id'])
                            @include('store.components.categories.item', ['category' => $category])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
