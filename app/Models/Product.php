<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public $fillable = ['name', 'slug', 'price','category_id','content','image','gallery_images'];
 
  protected $casts = [
    'image' => 'array',
    'gallery_images' => 'array',
   ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  


  
}
