<div class="brator-categories-single">
    <div class="brator-categories-single-img">
        <a href="#">
            <img width="98" height="96"
                 src="{{ asset($category['image'] ? 'storage/' . $category['image'] : 'images/default.png')}}"
                 class="attachment-full size-full" alt="">
        </a>
    </div>
    <div class="brator-categories-single-title">
        <p><a href="{{route('category', $category['slug'])}}">{{$category['name']}}</a></p>
    </div>
    <div class="brator-categories-single-sub">
{{--        @dd()--}}
        @if($category->children)
        @foreach($category->children as $key => $subCategory)
            @if($key < 2)
                <a href="{{route('category', $subCategory['slug'])}}">{{$subCategory['name']}}</a>
                @endif
            @endforeach
        @endif

    </div>
</div>
