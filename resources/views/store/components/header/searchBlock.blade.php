<div class="brator-header-area header-one">
    <div class="container-xxxl container">
        <div class="row">
            <div class="col-lg-3">
                <div class="brator-logo-area">
                    <div class="brator-logo">
                        <a href="/">
                            <img src="{{asset('images/logo.png')}}" height="100px" alt="Logo">
                        </a>
                        <button class="mobile-menu-icon" id="mobile-menu-icon">
                            <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="brator-search-area">
                    <div class="search-form">
                        <form method="get" action="{{route('catalog')}}" class="w-100">
                            <input class="search-field" id="prosearch" type="search" name="search"
                                   placeholder="Search by Part Name, Brand, Model, Sku">
                            <button type="submit">
                                <svg fill="#000000" width="52" height="52" version="1.1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     x="0px" y="0px" viewBox="0 0 64 64">
                                    <path
                                        d="M62.1,57L44.6,42.8c3.2-4.2,5-9.3,5-14.7c0-6.5-2.5-12.5-7.1-17.1v0c-9.4-9.4-24.7-9.4-34.2,0C3.8,15.5,1.3,21.6,1.3,28c0,6.5,2.5,12.5,7.1,17.1c4.7,4.7,10.9,7.1,17.1,7.1c6.1,0,12.1-2.3,16.8-6.8l17.7,14.3c0.3,0.3,0.7,0.4,1.1,0.4 c0.5,0,1-0.2,1.4-0.6C63,58.7,62.9,57.6,62.1,57z M10.8,42.7C6.9,38.8,4.8,33.6,4.8,28s2.1-10.7,6.1-14.6c4-4,9.3-6,14.6-6c5.3,0,10.6,2,14.6,6c3.9,3.9,6.1,9.1,6.1,14.6S43.9,38.8,40,42.7C32,50.7,18.9,50.7,10.8,42.7z"></path>
                                </svg>
                            </button>
                        </form>
                        <div id="productdatasearch"></div>
                    </div>
                    <div class="search-quly">
                        <p>QUICK SEARCH:</p>
                        <a href="{{route('category', ['engine-parts'])}}">Engine parts</a>
                        <a href="{{route('category', ['brakes-components'])}}">Brakes & Components</a>
                        <a href="{{route('category', ['batteries'])}}">Batteries</a>
                        <a href="{{route('category', ['wheels-tires'])}}">Wheels & Tires</a>
                        <a href="{{route('category', ['exhaust-systems'])}}">Exhaust Systems</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="brator-info-right">
                    <div class="brator-icon-link-text relation">
                        <a href="javascript:void(0)">
                            <div class="click-item-count">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64"
                                     xml:space="preserve">
					<g>
                        <g>
                            <path
                                d="M32.1,37.3c-8.8,0-16-7.2-16-16s7.2-16,16-16s16,7.2,16,16S40.9,37.3,32.1,37.3z M32.1,10.7c-5.9,0-10.7,4.8-10.7,10.7S26.3,32,32.1,32s10.7-4.8,10.7-10.7S38,10.7,32.1,10.7z"></path>
                        </g>
                        <g>
                            <path
                                d="M2.8,58.7c-0.8,0-1.6-0.3-2.1-1.1c-1.1-1.1-0.8-2.9,0.3-3.7c8.8-7.2,19.7-11.2,31.2-11.2s22.4,4,30.9,11.2c1.1,1.1,1.3,2.7,0.3,3.7c-1.1,1.1-2.7,1.3-3.7,0.3C52.1,51.5,42.3,48,32.1,48s-20,3.5-27.7,10.1C4.1,58.4,3.3,58.7,2.8,58.7z"></path>
                        </g>
                    </g>
				</svg>
                            </div>
                            <b>My Account</b>
                        </a>
                        <div class="vehicle-list-wapper">

                        </div>
                    </div>
                    @include('store.components.cart.previewInHeader')
                </div>
            </div>
        </div>
    </div>
</div>
