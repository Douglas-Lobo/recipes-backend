<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        "name",
        "description"
      ];


   public function Recipes()
   {
       return $this->belongsToMany(Recipe::class, 'categories_recipes');
   }
}
