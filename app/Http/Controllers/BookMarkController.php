<?php

namespace App\Http\Controllers;

use App\Models\BookMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookMarkController extends Controller
{
    public function bookMark(Request $request){

        $request->validate([

            'recipe_id' => 'required',

            'is_bookmark' => 'required',

        ]);

        $return_data = false;

        if (request()->ajax()) {
            $recipe_id = $request->recipe_id;
            $user_id = Auth::user()->id;
            $is_bookmark = $request->is_bookmark;

            $existing_bookmark = BookMark::where('user_id',$user_id)->where('recipe_id',$recipe_id)->first();
            if($existing_bookmark){
                  $existing_bookmark->is_bookmark = $is_bookmark;
                  $existing_bookmark->update();
            }else{
                BookMark::create([
                    'user_id' => $user_id,
                    'recipe_id' => $recipe_id,
                    'is_bookmark' => $is_bookmark
                ]);
            }
            $return_data = true;
            return json_encode($return_data);
        }

        return json_encode($return_data);

    }
}
