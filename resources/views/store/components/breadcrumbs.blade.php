<section class="brator-breadcrumb-area">
    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brator-breadcrumb">
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
                                        property="name">{{ trans('interface.breadcrumbs.' . $breadcrumb['name']) }}</span>
                                </a>
                                <meta property="position" content="1">
                            </span>
                                        @else
                                        <span
                                            property="name">{{ trans('interface.breadcrumbs.' . $breadcrumb['name']) }}</span>
                                        @endif
                                </li>
                            @endforeach
                        @else
                                <li>
                                    <a href="/"><span>{{ trans('interface.breadcrumbs.home') }}</span></a>
                                </li>
                            <li>
                                   <span>{{ trans('interface.breadcrumbs.products') }}</span>
                                </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
