<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Events table intentionally doesn't include Laravel timestamps
    public $timestamps = false;

    // Adjusted to match the existing DB columns: nama_acara, tanggal, waktu_mulai, waktu_selesai, tempat, kategori
    protected $fillable = [
        'nama_acara',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'kategori',
    ];

    protected $casts = [
        // tanggal holds the date of the event
        'tanggal' => 'date',
        // waktu_mulai / waktu_selesai are stored as time strings (H:i)
    ];

    // No creator relation — events table intentionally contains only the requested columns
}
