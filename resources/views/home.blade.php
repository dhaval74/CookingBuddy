@extends('layouts.app')   

@section('content')

<div class="container">

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">
                {{-- @if(Auth::check())
                    <a class="btn btn-primary" href="{{ route('recipes.index') }}"> Back</a>
                @endif --}}
                <h2>Show All Recipe</h2>
            </div>
            <div class="pull-right">
                <input type="text" class="form-control pull-right" id="myInput" name="myInput" placeholder="Search...">
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <input type="hidden" name="type" id="type" value="{{ app('request')->input('type') }}">
    <div class="row g-2 recipe-view">
        @include('welcome',[
            'recipes' => $recipes,
            'rating' => $rating
        ])        
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {        
        // /keyup
        $(document).on('keyup', '#myInput', function() {
            key = $("#myInput").val();
            let type = $("#type").val();
            let url = 'home';
            if(type == 'bookmarks'){
                url = 'home?type=bookmarks';
            }

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'search' : key
                    },
                    success: function(data) {
                        $('.recipe-view').html("");
                        $(".recipe-view").append(data);
                    },error:function(error){
                        console.log(error);
                    }
                });            
        });

    
        $(document).on('click', '.recipe-bookmark', function() {
            let recipe_id = $(this).find('#recipe_id').val();
            let is_bookmark = $(this).find('#is_bookmark').val();
            const that = this; // save 
            
            if(+is_bookmark == 0){
                is_bookmark = 1;
            }else{
                is_bookmark = 0;
            }
            $.ajax({
                    url: 'bookmark',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'recipe_id' : recipe_id,
                        'is_bookmark' : is_bookmark
                    },
                    success: function(data) {
                        if(data){
                            if(is_bookmark){
                                $(that).find('.glyphicon-bookmark').attr("style", "color:blue");
                                $(that).find('#is_bookmark').val(is_bookmark);
                            }else{
                                $(that).find('.glyphicon-bookmark').removeAttr('style');
                                $(that).find('#is_bookmark').val(is_bookmark);
                            }
                        }
                        
                    },error:function(error){
                        console.log(error);
                    }
            });     
            
            
        });     

    });
</script>
@endsection