<ul id="menu-primary-menu" class="list-style-outside-none hover-menu-enable">
    <li
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-has-children dropdown menu-item-1189 nav-item">
        <a href="/" aria-haspopup="true">{{ trans('interface.header.home') }}</a>
    </li>
    <li
        class="menu-item menu-item-type-taxonomy menu-item-object-product_cat nav-item">
        <a href="{{route('categories')}}">{{ trans('interface.header.allCategories') }}</a></li>
    <li
        class="menu-item menu-item-type-taxonomy menu-item-object-product_cat nav-item">
        <a href="{{route('catalog')}}">{{ trans('interface.header.productsCatalog') }}</a></li>

    <li id="menu-item-2476"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2476 nav-item">
        <a href="{{route('infoContactUs')}}">{{ trans('interface.header.contactUs') }}</a></li>
</ul>
