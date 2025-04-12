<?php

namespace App\Services;

use App\Interfaces\SupportsFileUpload;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesManagingService
{
    public function getProductImages(array $products): Collection
    {
       return Media::query()
           ->whereIn('id', $products)
           ->get();
    }
    public function getMainImages(array $products): Collection
    {
       return Media::query()
           ->whereIn('model_id', $products)
           ->where('order_column', 1)
           ->get();
    }
}
