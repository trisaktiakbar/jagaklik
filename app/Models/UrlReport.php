<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlReport extends Model
{
    protected $fillable = [
        'url',
        'domain_url',
        'category',
        'description',
        'evidence',
        'reporter_name',
        'reporter_email',
        'reporter_ip',
    ];
}
