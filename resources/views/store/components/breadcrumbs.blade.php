<section class="rp-breadcrumb-area">
    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rp-breadcrumb">
                    <ul>

                        @if(!empty($breadcrumbs))
                            @foreach($breadcrumbs as $breadcrumb)
                                <li>
                                    @if(isset($breadcrumb['url']))
                            <span property="itemListElement" typeof="ListItem">
                                <a property="item" typeof="WebPage" title=""
                                   href="{{$breadcrumb['url']}}"
                                   class="home">
                                    <span
                                        property="name">{{ trans('interface.' . $breadcrumb['name']) }}</span>
                                </a>
                                <meta property="position" content="1">
                            </span>
                                        @else
                                        <span
                                            property="name">{{ $breadcrumb['name'] }}</span>
                                        @endif
                                </li>
                            @endforeach
                        @else
                                <li>
                                    <a href="/"><span>{{ trans('interface.homepage') }}</span></a>
                                </li>
                            <li>
                                   <span>{{ trans('interface.productsPage') }}</span>
                                </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
