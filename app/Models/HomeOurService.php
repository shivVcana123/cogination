<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeOurService extends Model
{
    use HasFactory;
    protected $table = 'home_our_services';
    protected $fillable = ['id', 'title', 'subtitle', 'description_1', 'pointers'];
}
