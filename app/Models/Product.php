<?php

namespace App\Models;

use App\Constant\FilesConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;

use function Laravel\Prompts\select;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'brand_id', 'mnf_code'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductFile::class)
            ->where('category', FilesConstants::IMAGE)
            ->orderBy('order');
    }

    //TODO move repeated methods
    public function mainImage()
    {
        return $this->hasOne(ProductFile::class)->where('category', 'image')->orderBy('order');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function priceByCurrency(?int $currency = null): HasOne
    {
        //Save currency id to session
        return $this->hasOne(ProductPrice::class)
            ->where('currency_id', $currency ?? 1)
            ->select(['price', 'discounted_price', 'discount_amount']);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translationByLanguage(?string $language = null): HasOne
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('language', $language ?? App::getLocale())
            ->select(['name', 'description']);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProductFile::class)
            ->where('category', FilesConstants::DOCUMENT)
            ->orderBy('order');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class, 'product_option_values');
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function setImagesAttribute($value)
    {
        $attribute_name = "images";
        dd($value);
        // you can check here if file is recieved or not using hasFile()
        $disk = "public";
        $destination_path = "/uploads";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
