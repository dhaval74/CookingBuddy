<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function profile(){
        Log::info("ev");
        return view('profile');
    }

        /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function setProfile(Request $request){

        $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|string|max:255',

        ]);

        $input = $request->all();
        unset($input['_token']);

        if ($image = $request->file('profile')) {

            $request->validate([
                'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $destinationPath = 'profile/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['profile'] = $destinationPath.$profileImage;

        }else{
            unset($input['profile']);
        }

        $user = User::where('id',Auth::user()->id)->update($input);

        return redirect()->back()

        ->with('success','Profile updated successfully');


    }
}
