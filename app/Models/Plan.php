<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'number_of_qrcodes',
        'price_id',
    ];

    public function Subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
