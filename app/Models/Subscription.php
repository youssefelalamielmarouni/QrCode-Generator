<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'Stripe_subscription_id',
        'status',
        'stripe_plan_id',
        'current_period_start',
        'current_period_end',
        'user_id',
        'plan_id',
    ];

    public function Plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
