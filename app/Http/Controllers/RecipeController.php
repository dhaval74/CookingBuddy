<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RecipeController extends Controller
{
    public function index(){
       
        if (request()->ajax()) {
            $userId = Auth::user()->id;

            $user = User::where('id','=',$userId)->with('recipes')->first();
            return DataTables::of($user['recipes'])
                ->addIndexColumn()
                ->addColumn('action',function($row){

                    $edit = route('recipes.edit',$row->id);
                    $show = route('recipes.show',$row->id);
                    $destroy =  route('recipes.destroy',$row->id);

                    $action = '
                    <form action="'.$destroy.'" method="POST">
                    <a class="btn btn-info" href="'.$show.'">Show</a>
                    <a class="btn btn-primary" href="'.$edit.'">Edit</a>
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                    </form>
                ';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $recipes = Recipe::latest()->paginate(5);
    
        return view('recipes.index',compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

   /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('recipes.create');

    }

    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $request->validate([

            'recipe_name' => 'required|string|max:255',

            'ingredients' => 'required|string|max:255',

            'detail' => 'required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

  

        $input = $request->all();

  

        if ($image = $request->file('image')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = $destinationPath.$profileImage;

        }

        $user = User::find(Auth::user()->id);
        $user->recipes()->create($input);     

        return redirect()->route('recipes.index')

                        ->with('success','Recipe created successfully.')->withInput();

    }

     
    // * @param  \App\Recipe  $recipe

    /**

     * Display the specified resource.

     *


     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $recipe = Recipe::with('reviews','reviews.user')->where('id',$id)->first();

        // $recipe->reviews = $recipe->reviews;
        // $recipe->reviews->user = $recipe->reviews->user;
        $reting_sum = $recipe->reviews->sum('rating');

        $user_rating = $recipe->reviews->where('user_id',Auth::id())->first();
        Log::info($recipe);
        
        if($recipe->reviews->count() > 0){
            $rating_value = $reting_sum / $recipe->reviews->count(); 
        }else{
            $rating_value = 0;
        }
        return view('recipes.show',compact('recipe','rating_value','user_rating'));

    }

     

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Recipe  $recipe

     * @return \Illuminate\Http\Response

     */

    public function edit(Recipe $recipe)

    {

        return view('recipes.edit',compact('recipe'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Recipe  $recipe

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Recipe $recipe)

    {

        $request->validate([

            'recipe_name' => 'required|string|max:255',
            
            'ingredients' => 'required|string|max:255',

            'detail' => 'required',
        ]);

        $input = $request->all();  

        if ($image = $request->file('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = $destinationPath.$profileImage;

        }else{

            unset($input['image']);

        }

          

        $recipe->update($input);

    

        return redirect()->route('recipes.index')

                        ->with('success','Recipe updated successfully');

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Recipe  $recipe

     * @return \Illuminate\Http\Response

     */

    public function destroy(Recipe $recipe)

    {

        $recipe->delete();

        return redirect()->route('recipes.index')

                        ->with('success','Recipe deleted successfully');

    }



    public function getAllRecipe(Request $request){
        $type = 0;
        if(isset($request->type)){
            $type = $request->type;
        }
        $recipes = Recipe::with('user','reviews','bookmarks')                  
                   ->orderBy('id', 'DESC');

                   if($type =='bookmarks'){
                    $recipes->whereHas('bookmarks',function($q) use($type){
                        if($type == 'bookmarks'){
                             $q->where('user_id',Auth::id())->where('is_bookmark','1');
                        }
                    });
                }
                   
        if (request()->ajax()) {
            $search = request()->search; 

            if(!empty($search)){
                $recipes = $recipes->where(function ($query) use ($search) {
                    $query->orWhere('recipe_name', 'LIKE', '%' . $search . '%');
                    // $query->orWhere('detail', 'LIKE', '%' . $search . '%');
                });
            }            
        }
        $recipes = $recipes->get();
       
        $rating = [];

        foreach($recipes as $recipe){
            $rating[$recipe->id] = 0;
            if(!empty($recipe->reviews)&& count($recipe->reviews) > 0){
                foreach($recipe->reviews as $review){
                    $rating[$recipe->id]+=$review->rating;
                }
                $rating[$recipe->id] = $rating[$recipe->id] / count($recipe->reviews);
            }          

        }

        if (request()->ajax()) {
            return view('welcome',compact('recipes','rating'))->render();
        }else{
            return view('home',compact('recipes','rating'));
            
        }

    }
}
// 