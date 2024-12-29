<?php

namespace App\Models;

use App\Constant\FilesConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;



class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'description', 'brand_id', 'mnf_code', 'images'];
    protected $casts = [
        'images' => 'array',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
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

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('discount', 'amount');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProductFile::class)
            ->where('category', FilesConstants::DOCUMENT)
            ->orderBy('order');
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }
}
