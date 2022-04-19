@extends('layouts.app')   

@section('content')

<div class="container">

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
    <br>

     <div class="row">
        @foreach($recipes as $recipe)        
            <div class="card" style="width:400px">
                <img class="card-img-top" src="/image/{{ $recipe->image }}" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title">{{ $recipe->recipe_name }}</h4>
                    {{-- <p class="card-text">{{ $recipe->detail }}</p> --}}
                    <a href="{{ route('recipes.show',$recipe->id) }}" class="btn btn-primary">See More</a>
                </div>
            </div>
        @endforeach
    </div> 

    {{--  --}}
</div>

@endsection