<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'strCategoryName',
        'strSlug',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
        'created_at',
        'updated_at',
        'strIP'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
