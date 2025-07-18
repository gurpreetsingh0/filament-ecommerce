<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public $fillable = ['name','slug', 'status'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }
}
