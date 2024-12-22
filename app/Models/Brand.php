<?php

namespace App\Models;

use App\Constant\FilesConstants;
use App\Interfaces\SupportsFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model implements SupportsFileUpload
{
    protected $fillable = ['name', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BrandFile::class)
            ->where('category', FilesConstants::IMAGE)
            ->orderBy('order');
    }

    public function mainImage()
    {
        return $this->hasOne(BrandFile::class)->where('category', 'image')->orderBy('order');
    }

    public function getFolderName(): string
    {
        return 'brands';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }
}
