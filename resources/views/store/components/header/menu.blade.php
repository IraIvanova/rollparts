<nav class="navbar navbar-expand-lg">
    <ul id="menu-primary-menu" class="list-style-outside-none hover-menu-enable main-nav">
        <li
            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-has-children dropdown menu-item-1189 nav-item">
            <a href="/" aria-haspopup="true">{{ trans('interface.header.home') }}</a>
        </li>
        <li
            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat dropdown">
            <a class="dropdown-toggle" href="{{route('categories')}}">{{ trans('interface.header.allCategories') }}</a>
            <div class="dropdown-menu nav-item p-4" aria-labelledby="navbarDropdown">
                    <div class="row">
                            <ul class="sub-menu row">

                                @foreach($categories as $category)
                                    <li class="main-category">
                                        <a href="{{route('category', $category['slug'])}}">{{ trans('interface.' . $category['slug']) }}</a>
                                        @include('store.components.header.subMenu', $category)
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                </div>
        </li>
        <li
            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat nav-item">
            <a href="{{route('category', ['engine-parts'])}}">{{ trans('interface.engine-parts') }}</a></li>
        <li
            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat nav-item">
            <a href="{{route('category', ['exhaust-pipes'])}}">{{ trans('interface.exhaust-pipes') }}</a></li>

        <li id="menu-item-2476"
            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2476 nav-item">
            <a href="{{route('infoContactUs')}}">{{ trans('interface.header.contactUs') }}</a></li>
    </ul>
</nav>
