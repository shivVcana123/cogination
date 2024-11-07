<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['categories_id','title','url'];

    public function category(){
        return $this->belongsTo(Category::class,'categories_id');
    }
}
