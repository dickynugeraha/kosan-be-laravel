<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        "total_price",
        "payment_method",
        "period_order",
        "start_order",
        "end_order",
        "user_id",
        "room_id",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
