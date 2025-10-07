<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryId',
        'subcategoryid',
        'productname',
        'slugname',
        'rate',
        'cut_price',
        'AmountWithOutGST',
        'iGST',
        'iGSTAmount',
        'weight',
        'description',
        'isFeatures',
        'isTaxable',
        'isStock',
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
