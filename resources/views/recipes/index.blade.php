@extends('layouts.app')
     
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            {{-- <div class="pull-left">
                <h2>Laravel 8 CRUD with Image Upload Example from scratch - ItSolutionStuff.com</h2>
            </div> --}}
            <div class="pull-left">
                <a class="btn btn-success" href="{{ route('recipes.create') }}">Create Recipe</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @else
    <br>
    @endif
    <div class="card-body">
             
        <div class="table-responsive mt-3">
            <table class="table table-striped mg-b-0 text-md-nowrap datatable" >
                <thead>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Recipe Name')}}</th>
                        <th>{{__('Ingredients')}}</th>
                        <th>{{__('Details')}}</th>
                        <th width="280px">{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
    {!! $recipes->links() !!}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

      // DataTable
      $('.datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax:{
             url:"{{ route('recipes.index') }}",
             type: "GET"
         } ,
         columns: [
            { data: 'id' ,name :'id' },
            { data: 'ingredients' ,name :'ingredients' },
            { data: 'recipe_name' ,name :'recipe_name' },
            { data: 'detail' ,name :'detail' },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            }
         ]
      });

    });
    </script>

@endsection