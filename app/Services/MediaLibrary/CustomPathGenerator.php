<?php

namespace App\Services\MediaLibrary;

use App\Models\Payment;
use App\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $folder = match ($media->model_type) {
            Payment::class => 'payments/',
            Product::class => 'products/',
        };

        return $folder . $media->model->id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
