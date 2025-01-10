<div class="brator-header-menu-area scroll-menu" id="scroll-menu">
    <div class="close-menu-bg"></div>
    <div class="brator-mega-menu-close">
        <svg class="bi bi-x" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
        </svg>
    </div>
    <div class="container-xxxl container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brator-header-menu-with-info">
                    <div class="brator-logo-area">
                        <div class="brator-logo">
                            <a href="https://brator-main.smartdemowp.com/">
                                <img src="{{asset('images/logo.png')}}" alt="Logo">
                            </a>
                            <button class="mobile-menu-icon">
                                <svg class="bi bi-pause" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M6 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="brator-header-menu sticky-menu">
                        @include('store.components.header.menu')
                    </div>
                    <div class="brator-header-menu-info"><a href="/">Track
                            Order</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
