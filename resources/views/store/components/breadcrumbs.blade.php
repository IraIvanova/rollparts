<section class="brator-breadcrumb-area">
    <div class="container-xxxl container-xxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brator-breadcrumb">
                    <ul>
                        <li>
                            <span property="itemListElement" typeof="ListItem">
                                <a property="item" typeof="WebPage" title=""
                                   href="/"
                                   class="home">
                                    <span
                                        property="name">Home</span>
                                </a>
                                <meta property="position" content="1">
                            </span>
                        </li>
                        @if(isset($breadcrumbs))
                            @foreach($breadcrumbs as $breadcrumb)
                                <li>
                                    @if(isset($breadcrumb['url']))
                            <span property="itemListElement" typeof="ListItem">
                                <a property="item" typeof="WebPage" title=""
                                   href="{{$breadcrumb['url']}}"
                                   class="home">
                                    <span
                                        property="name">{{$breadcrumb['name']}}</span>
                                </a>
                                <meta property="position" content="1">
                            </span>
                                        @else
                                        <span
                                            property="name">{{$breadcrumb['name']}}</span>
                                        @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
