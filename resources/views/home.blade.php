@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="card-title">{{__('Collection List')}} </h4>                
            </div>
            <div class="card-body">
             
                <div class="table-responsive mt-3">
                    <table class="table table-striped mg-b-0 text-md-nowrap datatable" >
                        <thead>
                            <tr>
                                <th>{{__('ID')}}</th>
                                {{-- <th>{{__('User Name')}}</th> --}}
                                <th>{{__('Recipe Name')}}</th>
                                <!--<th>{{__('Description')}}</th>
                                <th>{{__('Created At')}}</th>
                                <th style="width:150px !important">{{__('Action')}}</th> -->
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
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
             url:"{{ route('recipe.index') }}",
             type: "GET"
         } ,
         columns: [
            { data: 'id' ,name :'id' },
            // { data: 'name' ,name :'name' },
            { data: 'recipe_name' ,name :'recipe_name' }
         ]
      });

    });
    </script>
@endsection
