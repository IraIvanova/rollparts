<div class="rollparts-categories-single">
    <div class="rollparts-categories-single-img">
        <a href="{{route('category', $category['slug'])}}">
            <img width="98" height="96"
                 src="{{ asset($category['image'] ? 'storage/' . $category['image'] : 'images/default.png')}}"
                 class="attachment-full size-full" alt="">
        </a>
    </div>
    <div class="rollparts-categories-single-title">
        <p><a href="{{route('category', $category['slug'])}}">{{ trans('interface.' . $category['slug']) }}</a></p>
    </div>
    <div class="rollparts-categories-single-sub">
        @if($category['children'])
        @foreach($category['children'] as $key => $subCategory)
            @if($key < 2)
                <a href="{{route('category', $subCategory['slug'])}}">{{ trans('interface.' . $subCategory['slug']) }}</a>
                @endif
            @endforeach
        @endif

    </div>
</div>
