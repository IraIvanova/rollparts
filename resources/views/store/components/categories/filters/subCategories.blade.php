<ul>
    @foreach($category['children'] as $subCategory)

        <li class="cat-item sub-cat {{empty($subCategory['children'] ? '' : 'cat-parent')}}">
            <a href="{{route('category', $subCategory['slug'])}}">{{$subCategory['name']}}</a>

            @if(!empty($subCategory['children']))
                @include('store.components.categories.filters.subCategories', ['category' => $subCategory])
            @endif
        </li>

    @endforeach
</ul>
