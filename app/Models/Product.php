<?php

namespace App\Models;

use App\Constant\FilesConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;

use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Searchable;

    protected $fillable = ['id', 'name', 'slug', 'description', 'mnf_code', 'images', 'color_id', 'manufacturer_id'];
    protected $casts = [
        'images' => 'array',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(100);

        $this->addMediaConversion('image-md')
            ->format('webp')
            ->width(600)
            ->optimize();

        $this->addMediaConversion('image-sm')
            ->format('webp')
            ->width(200)
            ->optimize();

        $this->addMediaConversion('image-lg')
            ->format('webp')
            ->width(1200)
            ->optimize();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')
            ->useDisk('public');
    }

    public function toSearchableArray(): array
    {
        $this->loadMissing('translationByLanguage', 'priceByCurrency', 'carModels');

        return [
            'id' => $this->id,
            'mnf_code' => $this->mnf_code,
            'translation' => $this->translationByLanguage?->name,
            'description' => $this->translationByLanguage?->description,
            'category_ids' => $this->categories->pluck('id'),
            'discounted_price' => $this->priceByCurrency?->discounted_price,
            'make_names' => $this->carModels->pluck('make.name')->unique()->values()->toArray(),
            'car_model_names' => $this->carModels->pluck('model')->unique()->values()->toArray(),
        ];
    }

    public function productVariants()
    {
        return $this->belongsToMany(Product::class, 'product_variants', 'main_product_id', 'variant_id')
            ->with('color');
    }

    public function variant()
    {
        return $this->belongsTo(Product::class, 'variant_id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function carModels(): BelongsToMany
    {
        return $this->belongsToMany(CarModel::class, 'car_model_product')
            ->withPivot('car_year_id');
    }

    public function carModelProducts(): HasMany
    {
        return $this->hasMany(CarModelProduct::class);
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
            ->select('product_id', 'price', 'discounted_price', 'discount_amount');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translationByLanguage(): HasOne
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('language', 'tr');
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

    public function stock(): HasOne
    {
        return $this->hasOne(ProductStock::class);
    }

    public function inventory(): Hasmany
    {
        return $this->hasMany(Inventory::class);
    }

    public function frequentlyBoughtTogether(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'frequently_bought_products', 'product_id', 'related_product_id');
    }

    public function getTranslationNameAttribute()
    {
        return $this->translationByLanguage['name'] ?? '';
    }
}
