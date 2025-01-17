<div class="brator-slide-menu-area" id="slide-sidebar-menu">
    <div class="brator-slide-menu-bg"></div>
    <div class="brator-slide-menu-content slide-sidebar-menu-content">
        <div class="brator-slide-menu-close" id="slide-menu-close">
            <svg class="bi bi-x" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 viewBox="0 0 16 16">
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
        </div>
        <div class="brator-slide-logo-items">
            <a href="/">
                <img src="{{asset('images/logo.png')}}" alt="Logo">
            </a>
            <button class="header-sidebar-icon">
                <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                </svg>
            </button>
            <button class="mobile-menu-icon">
                <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                </svg>
            </button>

            <button class="header-sidebar-icon">
                <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                </svg>
            </button>
            <button class="mobile-menu-icon">
                <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                </svg>
            </button>
        </div>
        <div class="brator-slide-menu-items">
            @include('store.components.header.menu')
        </div>
        <ul>
            <li class="p-2">
                <div class="brator-icon-link-text relation">
                    <a href="{{ route('client.account') }}" class="d-flex">
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
                        <b>{{ $user ? $user->name : trans('interface.header.myAccount')}}</b>
                    </a>
                </div>
            </li>
            <li class="p-2">
                <a href="{{ route('cart') }}" class="d-flex">
                    <div class="brator-cart-icon click-item-count" id="cart-icon">
                        <svg fill="#000000" width="52" height="52" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 64 64">
                            <g>
                                <path
                                    d="M40.9,48.2c-3.9,0-7.1,3.3-7.1,7.3c0,4,3.2,7.3,7.1,7.3s7.1-3.3,7.1-7.3C48.1,51.5,44.9,48.2,40.9,48.2z M40.9,59.3c-2,0-3.6-1.7-3.6-3.8c0-2.1,1.6-3.8,3.6-3.8s3.6,1.7,3.6,3.8C44.6,57.6,42.9,59.3,40.9,59.3z"></path>
                                <path
                                    d="M18.2,48.2c-3.9,0-7.1,3.3-7.1,7.3c0,4,3.2,7.3,7.1,7.3s7.1-3.3,7.1-7.3C25.4,51.5,22.2,48.2,18.2,48.2z M18.2,59.3c-2,0-3.6-1.7-3.6-3.8c0-2.1,1.6-3.8,3.6-3.8s3.6,1.7,3.6,3.8C21.9,57.6,20.2,59.3,18.2,59.3z"></path>
                                <path
                                    d="M57.8,1.3h-6.4c-1.5,0-2.8,1.1-3,2.6l-1.8,13.2H7.3c-0.9,0-1.7,0.4-2.2,1.1c-0.5,0.7-0.7,1.6-0.5,2.4c0,0,0,0.1,0,0.1l6.1,18.9c0.3,1.2,1.4,2.1,2.8,2.1h29.5c2.2,0,4-1.6,4.3-3.8l4.6-33.2h6c1,0,1.8-0.8,1.8-1.8S58.8,1.3,57.8,1.3z M43.7,37.4 c-0.1,0.4-0.4,0.8-0.9,0.8h-29L8.1,20.6h37.9L43.7,37.4z"></path>
                            </g>
                        </svg>
                        <span class="header-cart-count">{{$shoppingCart['totalItems']}}</span>
                    </div>
                    <b class="header-cart-total"><span class="woocommerce-Price-amount amount"><span
                                class="woocommerce-Price-currencySymbol">{{ trans('interface.shoppingCart') }} </span></span></b>

                </a>
            </li>
        </ul>


        </div>
    </div>
</div>
