<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'number_room',
        'price',
        "status",
        "description",
        "photos",
    ];

    public function order()
    {
        return $this->hasOne(Orders::class);
    }
}
