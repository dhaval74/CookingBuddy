@foreach($recipes as $recipe)   
            <div class="col-md-3">
                <div class="card p-2 py-3 text-center">
                    <div class="img mb-2"> 
                        <img class="card-img-top" src="/{{ $recipe->image }}" alt="Card image">
                    </div>
                    <h5 class="mb-0">{{ $recipe->recipe_name }}</h5> 
                    <div class="ratings mt-2">
                        @php $ratenum = number_format($rating[$recipe->id]) @endphp
                        @for($i=1;$i<= $ratenum ;$i++)
                            <i class="fa fa-star" style="color: #fbc634;"></i>
                        @endfor
                        @for($j = $ratenum + 1 ; $j<=5 ;$j++)
                            <i class="fa fa-star"></i>
                        @endfor
                    </div>

                    <div class="mt-4 apointment">
                        
                        <a href="{{ route('recipes.show',$recipe->id) }}" class="btn btn-primary">See More</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        
                        @if(Auth::user() &&app('request')->input('type') != 'bookmarks')                        
                            <span class="recipe-bookmark">
                                <input type="hidden" name="recipe_id" id="recipe_id" value="{{ $recipe->id}}">
                                <input type="hidden" name="is_bookmark" id="is_bookmark" value=@if($recipe->bookmarks) {{$recipe->bookmarks->is_bookmark  }} @else 0 @endif>
                                @if($recipe->bookmarks && $recipe->bookmarks->is_bookmark == 1)
                                    <i class="fa fa-bookmark glyphicon-bookmark" style="color: blue;"></i>
                                @else
                                    <i class="fa fa-bookmark glyphicon-bookmark"></i>
                                @endif
                            </span>
                        @endif                        
                    </div>
                </div>
            </div>
@endforeach        