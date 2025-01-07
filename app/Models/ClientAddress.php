<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    protected $fillable = ['type', 'client_id','address_line1', 'country', 'state', 'city', 'zip'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address_line1} {$this->zip} {$this->state} {$this->city} {$this->country}";
    }
}
