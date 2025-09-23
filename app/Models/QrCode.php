<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $fillable = [
        'content',
        'qr_code_path',
        'user_id',
    ];
    
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
