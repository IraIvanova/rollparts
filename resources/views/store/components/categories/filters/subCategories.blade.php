<ul>
    @foreach($category['children'] as $subCategory)
        <li class="cat-item {{$subCategory['id'] === $selectedCategory['id'] ? 'selected' : ''}} {{empty($subCategory['children'] ? '' : 'cat-parent')}}">
            <a href="{{route('category', $subCategory['slug'])}}">{{$subCategory['name']}}</a>
            @if(!empty($subCategory['children']))
                @include('store.components.categories.filters.subCategories', ['category' => $subCategory])
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                </svg>
            @endif
        </li>
    @endforeach
</ul>
