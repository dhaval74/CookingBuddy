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

            // $users = Recipe::get();
            $userId = Auth::user()->id;

            $user = User::where('id','=',$userId)->with('recipes')->first();
            //$user = Recipe::where('user_id','=',$userId)->get();
            Log::info($user);
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
                // ->editColumn('date',function($row){
                //     return $row->created_at != null ? date('d M Y',strtotime($row->created_at)) : '-';
                // }) 
                // ->editColumn('image',function($row){
                //     return $row->src !=null ? '<img src="'.asset($row->src).'" width="50" height="50" />'  : '--';
                // })            
                // ->addColumn('action', function($row){
                //    return '';
                // })
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

            'recipe_name' => 'required',

            'detail' => 'required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

  

        $input = $request->all();

  

        if ($image = $request->file('image')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = "$profileImage";

        }

    $user = User::find(Auth::user()->id);
    $user->recipes()->create($input);

     

        return redirect()->route('recipes.index')

                        ->with('success','Recipe created successfully.');

    }

     

    /**

     * Display the specified resource.

     *

     * @param  \App\Recipe  $recipe

     * @return \Illuminate\Http\Response

     */

    public function show(Recipe $recipe)

    {

        return view('recipes.show',compact('recipe'));

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

            'recipe_name' => 'required',

            'detail' => 'required',

        ]);

  

        $input = $request->all();

  

        if ($image = $request->file('image')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = "$profileImage";

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
}
// 