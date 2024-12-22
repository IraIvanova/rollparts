<?php

namespace App\Services;

use App\Constant\FilesConstants;
use App\Interfaces\SupportsFileUpload;
use App\Models\BrandFile;
use App\Models\ProductFile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesManagingService
{
    public function saveFiles(array $files, SupportsFileUpload $entity)
    {
        foreach ($files as $index => $file) {
            $this->saveFile($file, $entity, $index);
        }
    }

    public function getProductImages(array $products): Collection
    {
        return ProductFile::where('category', FilesConstants::IMAGE)
            ->whereIn('product_id', $products)
            ->select('file_path', 'product_id')
            ->orderBy('order')
            ->get();
    }

    private function saveFile(UploadedFile $file, SupportsFileUpload $entity, int $index = 0)
    {
        $path = $file->store($entity->getFolderName(), 'public');

        BrandFile::create([
            'brand_id' => $entity->id,
            'file_path' => $path,
            'category' => 'image',
            'file_extension' => $file->getClientOriginalExtension(),
            'order' => $index,
        ]);
    }
}
