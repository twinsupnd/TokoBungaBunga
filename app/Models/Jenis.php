<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    /** @use HasFactory<\Database\Factories\JenisFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'price',
        'description',
        'stock',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
