@extends('layouts.app')   

@section('content')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ url('/add-rating-review')}}" method="POST">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rate this recipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="rate">
                    @if($user_rating && isset($user_rating))
                        @for($i=5 ; $i>= 1 ; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"  @if($i ==$user_rating->rating) checked @endif />
                            <label for="star{{ $i }}" title="text">{{ $i }} stars</label>
                        @endfor
                    @else                    
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="text">1 star</label>
                    @endif
                </div>
                <div>
                    <textarea class="form-control" style="height:150px" name="comment" placeholder="Detail">{{ $user_rating->comment ?? ""}}</textarea>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
      </div>
    </div>
  </div>

<div class="container">

    <div class="row">

        <div class="col-lg-8 margin-tb">

            <div class="pull-left">

                <h2> Show Recipe</h2>

            </div>
            {{-- @if(Auth::user())
                <div class="pull-right">

                    <a class="btn btn-primary" href="{{ route('recipes.index') }}"> Back</a>

                </div>
            @endif --}}

        </div>

    </div>
    @if(Auth::user())
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseIf($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @else
            <br>
        @endif
    @endif
    <br>
    @if(Auth::user() && Auth::user()->id != $recipe->user_id)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Rete this recipe
        </button><br><br>    
    @endif    

    <div class="row">
        <div class="card">
            <div class="rating">
                <div class="rate">

                        @php $ratenum = number_format($rating_value) @endphp
                        @for($i=1;$i<= $ratenum ;$i++)
                            <i class="fa fa-star" style="color: #fbc634;"></i>
                        @endfor
                        @for($j = $ratenum + 1 ; $j<=5 ;$j++)
                            <i class="fa fa-star"></i>
                        @endfor
                </div>
                <p>
                    @if(number_format($rating_value) > 0)
                    {{ number_format($rating_value) }} Rating
                    @else
                    No Rating
                    @endif
                </p>
            </div>
            <div class="card-body">
                <div class="col-md-10">
                <img class="card-img-top" src="/{{ $recipe->image }}" alt="Card image">
                </div>
                <h4 class="card-title">{{ $recipe->recipe_name }}</h4>
                <p class="card-text">{{ $recipe->detail }}</p>
            </div>

            <div class="card card-inner">
                @foreach($recipe['reviews'] as $reviews)
                {{-- {{$reviews}} --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">

                                <div class="comment-widgets">
                                    <div class="review mt-4">
                                        <div class="d-flex flex-row comment-user">
                                            @if($reviews['user']['profile'])
                                                    <img src="/{{ $reviews['user']['profile']}}" alt="user" width="50" class="rounded-circle"> 
                                                {{-- </div> --}}
                                            @else
                                                {{-- <div class="img mb-2">  --}}
                                                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" alt="user" width="50" class="rounded-circle">
                                                {{-- </div> --}}
                                            @endif
                                            <div class="ml-2">
                                                <div class="d-flex flex-row align-items-center">
                                                    <span class="name font-weight-bold">{{ $reviews['user']['name'] ?? "" }}</span>
                                                    <span class="dot">&nbsp;&nbsp;</span>
                                                    <span class="date">{{ date("m-d-Y H:i:s", strtotime($reviews['user']['created_at'])) }}</span></div>
                                                <div class="rating">
                                                    @for($i=1;$i<= $reviews['rating'] ;$i++)
                                                        <i class="fa fa-star" style="color: #fbc634;"></i>
                                                    @endfor
                                                    @for($j = $reviews['rating'] + 1 ; $j<=5 ;$j++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="comment-text">
                                                {{ $reviews['comment'] ?? "" }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Comment Row -->
                                    {{-- <div class="d-flex flex-row comment-row m-t-0">
                                        <div class="comment-text w-100">
                                            <h6 class="font-medium">{{ $reviews['user']['name'] ?? "" }}</h6> 
                                                <span class="m-b-15 d-block"> {{ $reviews['comment'] ?? "" }}</span>
                                            <div class="comment-footer"> <span class="text-muted float-right">April 14, 2019</span> 
                                                <div class="rate">
                                                    @for($i=1;$i<= $reviews['rating'] ;$i++)
                                                        <i class="fa fa-star" style="color: #fbc634;"></i>
                                                    @endfor
                                                    @for($j = $reviews['rating'] + 1 ; $j<=5 ;$j++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>  --}}
                                </div>

                                

                                {{-- <p>
                                    <strong>{{ $reviews['user']['name'] ?? "" }}</strong> 
                                    &nbsp;                          
                                    <span>
                                        {{ date("Y-m-d H:i:s", strtotime($reviews['user']['created_at'])) }}
                                    </span>                            
                                </p>
                                <p>
                                    {{ $reviews['comment'] ?? "" }}
                                </p>
                                <p class="text-secondary text-center">
                                    <div class="rate">
                                        @for($i=1;$i<= $reviews['rating'] ;$i++)
                                            <i class="fa fa-star" style="color: #fbc634;"></i>
                                        @endfor
                                        @for($j = $reviews['rating'] + 1 ; $j<=5 ;$j++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                    </div>
                                </p> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>


        </div>
    </div>
</div>


@endsection