<section class="elementor-section elementor-top-section elementor-element elementor-element-5c4cf735 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="5c4cf735" data-element_type="section">
    <div class="elementor-container elementor-column-gap-no">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-36c5b949" data-id="36c5b949" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
                <div class="elementor-element elementor-element-59d9e1bb elementor-widget elementor-widget-brator_shop_category" data-id="59d9e1bb" data-element_type="widget" data-widget_type="brator_shop_category.default">
                    <div class="elementor-widget-container">
                        <div class="brator-categories-list-area design-two gray-bg">
                            <div class="container-xxxl container-xxl container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="brator-section-header" style="justify-content:left">
                                            <div class="brator-section-header-title">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
