<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public $fillable = ['name', 'slug', 'price','category_id','content','image'];

  protected $casts = [
    'image' => 'array',
  ];
}
