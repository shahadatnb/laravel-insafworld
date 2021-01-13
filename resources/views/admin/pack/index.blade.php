@extends('layouts.master')
@section('title','Packegs')
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
          Packegs List {{-- <a href="{{url('dailyBonusDist')}}" class="btn btn-primary">Daily Bonus Dist</a> --}}
        </div>
        <div class="card-body">
          @include('layouts._message')           
          <table class="table">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Amount</th>
              <th>Payment</th>
              <th>Max %</th>
              <th>Min Withdraw</th>
              <th>Waiting Day</th>
              <th>Action</th>
            </tr>
            @foreach ($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->title }}</td>             
              <td>{{ $product->amount }}</td>             
              <td>{{ $product->payment }}</td>             
              <td>{{ $product->exp }}</td>
              <td>{{ $product->minWithdraw }}</td>
              <td>{{ $product->waiting_day }}</td>
              <td>                
                <a class="btn btn-success btn-xs" href="{{ route('packs.edit',$product->id) }}"><i class="fa fa-edit"></i>  Edit</a>
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