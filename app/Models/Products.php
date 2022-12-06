<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function slides()
    {
        return $this->hasMany(Slides::class, 'product_id', 'id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturers::class, 'manu_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'cate_id');
    }
}
