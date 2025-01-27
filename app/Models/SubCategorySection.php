<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorySection extends Model
{
    use HasFactory;

    protected $fillable =['first_title', 'category_section_id', 'type', 'first_subtitle', 'first_description', 'first_button_content', 'first_button_link', 'first_image', 'second_title', 'second_subtitle', 'second_description', 'second_button_content', 'second_button_link', 'second_image', 'pointers'];
}
