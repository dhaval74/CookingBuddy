<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
        'comment',
    ];

    protected $guarded = ['id'];



   public function user()
  {
    return $this->belongsTo(User::class,'user_id','id');
  }

  public function recipe()
  {
    return $this->belongsTo(Recipe::class,'recipe_id','id');
  }
}
