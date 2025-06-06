<section class="rp-section">
    <div class="container-xxxl container-xxl container">
        <div class="rp-makes-list-tab-header">
            <div class="mb-2">
                <h2>{{ trans('interface.home.featuredBrands') }}</h2>
            </div>
        </div>
        <div class="rp-makes-list-area mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="rp-makes-list">
                        @foreach($makes as $make)
                            <div class="rp-makes-list-single">
                                <a href="{{route('catalog',['carMakes' => $make->name])}}"><span>{{$make->name}}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
