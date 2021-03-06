<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function add(Request $request){
        $start_rated = $request->input('rating'); 
        $recipe_id = $request->input('recipe_id'); 
        $comment = $request->input('comment'); 

        $recipe_check = Recipe::where('id',$recipe_id)->where('status',"ACTIVE")->first();

        if($recipe_check){
            $existing_rating = Review::where('user_id',Auth::id())->where('recipe_id',$recipe_id)->first();
            if($existing_rating){
                  $existing_rating->rating = $start_rated;
                  $existing_rating->comment = $comment;
                  $existing_rating->update();
            }else{
                Review::create([
                    'user_id' => Auth::id(),
                    'recipe_id' => $recipe_id,
                    'rating' => $start_rated,
                    'comment' => $comment,
                ]);
            }
            return redirect()->back()->with('success',"Thank you for rating this Recipe");
        }else{
            return redirect()->back()->with('error','You can not rate this Recipe');
        }
    }
}
