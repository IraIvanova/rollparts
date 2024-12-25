<div class="gallery-part row">
    <div id="gallery" class="col-2">
        <div class="preview-group">
            @foreach($images as $key => $image)
                <a class="preview-img p-1 {{ $key === 0 ? 'selected' : '' }}" data-index="{{$key}}" data-imgsrc="{{ asset('storage' . $image['file_path'])}}">
                    <img src="{{ asset('storage' . $image['file_path'])}}">
                </a>
            @endforeach
        </div>
    </div>
    <div id="main-photo" class="col-10">
        <img id="main-gallery" data-index="0" src="{{ asset(isset($images[0]) ? 'storage' . $images[0]['file_path'] : 'images/default.png' )}}"/>
    </div>
</div>
