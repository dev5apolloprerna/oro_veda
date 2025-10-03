<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'strSequence',
        'subcategoryid',
        'categoryname',
        'slugname',
        'photo',
        'strGST',
        'created_at',
        'updated_at',
        'strIP',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'head',
        'body'
    ];
}
