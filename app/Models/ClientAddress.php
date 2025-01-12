<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAddress extends Model
{
    protected $fillable = ['type', 'client_id','address_line1', 'country', 'province_id', 'district_id', 'zip'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address_line1} {$this->zip} {$this->province->name} {$this->district->name} {$this->country}";
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
