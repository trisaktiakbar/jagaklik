<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlScan extends Model
{
    protected $fillable = [
        'url',
        'domain',
        'status',
        'total_sources',
        'successful_sources',
        'detected_sources',
        'results',
        'scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'results' => 'array',
            'scanned_at' => 'datetime',
        ];
    }
}
