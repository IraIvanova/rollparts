<section class="rollparts-section section-element rollparts-section-full_width rollparts-section-height-default rollparts-section-height-default">
    <div class="section-container section-column-gap-no">
        <div class="section-column section-col-100 section-element">
            <div class="section-widget-wrap section-element-populated">
                <div class="section-element section-widget">
                    <div class="section-widget-container">
                        <div class="rollparts-categories-list-area rollparts-design gray-bg">
                            <div class="container-xxxl container-xxl container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="rollparts-section-header" style="justify-content:left">
                                            <div class="rollparts-section-header-title">
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
