<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User_photo extends Model
{
    protected $table = 'user_photo';
    protected $fillable = [
        "image"
      ];

    public function User(){
        return $this->belongsTo(User::class);
    }


    public function getImageAttribute($value)
    {
        return url($value);
    }

}
