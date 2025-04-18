<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('confirmation')
            ->useDisk('public')
            ->singleFile();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
