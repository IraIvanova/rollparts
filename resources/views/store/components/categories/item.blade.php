<div class="rp-categories-single">
    <div class="rp-categories-single-img">
        <a href="{{route('category', $category['slug'])}}">
            <img width="98" height="96"
                 src="{{ asset($category['image'] ? 'storage/' . $category['image'] : 'images/default.png')}}"
                 class="attachment-full size-full" loading="lazy" alt="{{ trans('interface.' . $category['slug']) }}">
        </a>
    </div>
    <div class="rp-categories-single-title">
        <p><a href="{{route('category', $category['slug'])}}">{{ trans('interface.' . $category['slug']) }}</a></p>
    </div>
    <div class="rp-categories-single-sub">
        @if($category['children'])
        @foreach($category['children'] as $key => $subCategory)
            @if($key < 2)
                <a href="{{route('category', $subCategory['slug'])}}">{{ trans('interface.' . $subCategory['slug']) }}</a>
                @endif
            @endforeach
        @endif

    </div>
</div>
