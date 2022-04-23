<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Recipe extends Model
{
    use HasFactory ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_name',
        'image',
        'detail',
        'status'
    ];

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'recipe_id','id');
    }

    public function bookmarks()
    {
        return $this->hasOne(BookMark::class,'recipe_id','id')->where('user_id',Auth::id());
    }

}
