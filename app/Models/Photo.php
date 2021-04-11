<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        "image"
      ];

    public function Recipe(){
        return $this->belongsTo(Recipe::class);
    }

    public function getImageAttribute($value)
    {
        return url($value);
    }

}
