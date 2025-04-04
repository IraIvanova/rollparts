<div class="gallery-part row">
    <div id="gallery" class="col-2">
        <div class="preview-group">
            @if($images)
                @foreach($images as $key => $image)
                    <a class="preview-img p-1 {{ $key === 0 ? 'selected' : '' }}" data-index="{{$key}}"
                       data-imgsrc="{{$image->getFullUrl()}}">
                        <img src="{{$image->getFullUrl()}}" loading="lazy" alt="{{ $name . ' preview ' . $key+1 }}">
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    <div id="main-photo" class="col-10">
        <img id="main-gallery" data-index="0" src="{{ getMainImagePath($images)}}" loading="lazy" alt="{{$name}}" />
    </div>
</div>
