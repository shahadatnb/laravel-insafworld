@extends('layouts.master')
@section('title','VIP')
@section('stylesheet')
  <style>
    form.delete {
  display: inline;
}
</style>
  @endsection
@section('content')
<div class="content-wrapper">
   

      <!-- Default box -->
      <div class="card">
        <div class="card-header with-border">

        </div>
        <div class="card-body">
          @include('layouts._message')
          <table class="table">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Photo</th>
              <th>Action</th>
            </tr>
            @foreach ($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->title }}</td>
              <td><img height="50" width="50" src="{{url('public/upload/product')}}/{{ $product->photo }}" alt=""></td>              
              <td>
                <a class="btn btn-success btn-xs" href="{{ route('products.show',$product->id) }}"><i class="fa fa-eye"></i></a>
                <a class="btn btn-success btn-xs" href="{{ route('products.edit',$product->id) }}"><i class="fa fa-edit"></i>  Edit</a>
                
                  @if($product->status==0)
                    <a class="btn btn-primary btn-xs" href="{{ route('productHide',$product->id) }}">Show</a>
                  @else
                    <a class="btn btn-danger btn-xs" href="{{ route('productHide',$product->id) }}">Hide</a>
                  @endif
                
                <form class="delete" action="{{ route('products.destroy',$product->id) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-danger btn-xs" href='{{ $product->id }}' onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fa fa-trash"></i></button>
              </form>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    
    <!-- /.content -->
  </div>
 @endsection
    @section('scripts')
      <script>
        $('.select2').select2();
      </script>
    @endsection