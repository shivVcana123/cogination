<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'parent_id',
    ];    
    public function parent()
    {
        return $this->belongsTo(Header::class, foreignKey: 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Header::class, 'parent_id');
    }
}
