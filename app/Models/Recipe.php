<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Recipe extends Model
{
    protected $table = 'recipes';
    protected $appends = ['thumb'];
    protected $with = ['categories','photos'];
    protected $fillable = [
        "name",
        "user_id",
        "description",
        "preparation_time",
        "yield",
        "ingredients",
        "preparation_mode"
    ];

    public function getThumbAttribute(){
        $thumb = $this->Photos();
        if (!$thumb->count()) return null;

        return url($thumb->first()->image);
    }

    public function Categories()
    {
        return $this->belongsToMany(Category::class, 'categories_recipes');
    }

    public function Photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
