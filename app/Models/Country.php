<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'countryName',
        'slug_name',
        'iStatus',
        'isDelete',
        'strIP'
    ];
}
