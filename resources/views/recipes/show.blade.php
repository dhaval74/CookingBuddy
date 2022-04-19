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

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2> Show Recipe</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('recipes.index') }}"> Back</a>

            </div>

        </div>

    </div>
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
<br>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Rete this recipe
      </button>

      <br>    
      <br>    

    <div class="row">
        <div class="card">
            <div class="rating">
                {{-- @for($i=5 ; $i>= 1 ; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"  @if($i == number_format($rating_value)) checked @endif />
                    <label for="star{{ $i }}" title="text">{{ $i }} stars</label>
                @endfor --}}
                <p>
                    @if(number_format($rating_value) > 0)
                    {{ number_format($rating_value) }} Rating
                    @else
                    No Rating
                    @endif
                </p>
            </div>
            <img class="card-img-top" src="/image/{{ $recipe->image }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">{{ $recipe->recipe_name }}</h4>
                <p class="card-text">{{ $recipe->detail }}</p>
            </div>
        </div>
    </div>
</div>


@endsection