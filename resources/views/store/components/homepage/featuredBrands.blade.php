<section class="elementor-section elementor-top-section elementor-element elementor-element-2e350832 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="2e350832" data-element_type="section">
    <div class="elementor-container elementor-column-gap-no">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-40bf3c24" data-id="40bf3c24" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
                <div class="elementor-element elementor-element-ebfae6c elementor-widget elementor-widget-brator_tabs" data-id="ebfae6c" data-element_type="widget" data-widget_type="brator_tabs.default">
                    <div class="elementor-widget-container">
                        <div class="brator-makes-list-area design-two brator-makes-list-align-left">
                            <div class="container-xxxl container-xxl container">
                                <div class="brator-brator-makes-list-tab-list js-tabs" id="tabs-product-content">
                                    <div class="brator-makes-list-tab-header js-tabs__header">
                                        <div class="brator-section-header-title mb-2">
                                            <h2>Featured Brands</h2>
                                        </div>
                                    </div>
                                    <div>
                                        <div data-elementor-type="page" data-elementor-id="1007" class="elementor elementor-1007">
                                            <section class="elementor-section elementor-top-section elementor-element elementor-element-0a4e517 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="0a4e517" data-element_type="section">
                                                <div class="elementor-container elementor-column-gap-no">
                                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-61867ab" data-id="61867ab" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-a3aeb39 elementor-widget elementor-widget-brator_makes_list" data-id="a3aeb39" data-element_type="widget" data-widget_type="brator_makes_list.default">
                                                                <div class="elementor-widget-container">

                                                                    <div class="brator-makes-list-area">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="brator-makes-list">
                                                                                    @foreach($brands as $brand)
                                                                                    <div class="brator-makes-list-single ">
                                                                                        <a href="{{route('catalog',['brand' => $brand['slug']])}}"><span>{{$brand['name']}}</span>
                                                                                        </a>
                                                                                    </div>
                                                                                        @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="brator-makes-list-view-more">
                                                                                    <button> <span><b>view more</b>
						<svg class="bi bi-chevron-down" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg></span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- bread end-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
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
