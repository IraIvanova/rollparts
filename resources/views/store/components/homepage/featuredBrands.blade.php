<section class="rollparts-section  section-element rollparts-section-full_width rollparts-section-height-default rollparts-section-height-default">
    <div class="section-container section-column-gap-no">
        <div class="section-column section-col-100  section-element" >
            <div class="section-widget-wrap section-element-populated">
                <div class="section-element section-widget" >
                    <div class="section-widget-container">
                        <div class="rollparts-makes-list-area rollparts-design rollparts-makes-list-align-left">
                            <div class="container-xxxl container-xxl container">
                                <div>
                                    <div class="rollparts-makes-list-tab-header">
                                        <div class="rollparts-section-header-title mb-2">
                                            <h2>{{ trans('interface.home.featuredBrands') }}</h2>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <section class="rollparts-section section-element rollparts-section-full_width rollparts-section-height-default rollparts-section-height-default">
                                                <div class="section-container section-column-gap-no">
                                                    <div class="section-column section-col-100  section-element">
                                                        <div class="section-widget-wrap section-element-populated">
                                                            <div class="section-element section-widget">
                                                                <div class="section-widget-container">
                                                                    <div class="rollparts-makes-list-area mb-5">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="rp-makes-list">
                                                                                    @foreach($brands as $brand)
                                                                                    <div class="rollparts-makes-list-single ">
                                                                                        <a href="{{route('catalog',['brands' => $brand['name']])}}"><span>{{$brand['name']}}</span>
                                                                                        </a>
                                                                                    </div>
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
