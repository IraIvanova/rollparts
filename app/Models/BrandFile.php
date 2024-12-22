<?php

namespace App\Models;

use App\Constant\FilesConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandFile extends Model
{
    protected $fillable = ['category', 'file_path', 'brand_id', 'file_extension', 'order'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(BrandFile::class)->orderBy('order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(BrandFile::class)
            ->where('category', FilesConstants::IMAGE)
            ->orderBy('order');
    }

    public function otherFiles(): HasMany
    {
        return $this->hasMany(BrandFile::class)
            ->where('category', FilesConstants::DOCUMENT)
            ->orderBy('order');
    }
}
