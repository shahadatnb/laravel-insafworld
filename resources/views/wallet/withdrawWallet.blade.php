@extends('layouts.master')
@section('title',$walletName)
@section('content')
<div class="content-wrapper">
      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-yellow with-border">
          <strong class="card-title">Your {{$walletName}} Balance <i class="fa fa-dollar"></i>{{ $balance }}</strong>
        </div>
        <div class="card-body">
          <p>Transaction List</p>
          <table class="table table-striped">
            <tr>
              <th>Remark</th>
              <th>Receipt</th>
              <th>Withdraw</th>
              <th>Date</th>
              <th>#</th>
            </tr>
            @foreach ($transaction as $item)
            <tr>
              <td>{{ $item->remark }}</td>
              <td>{{ $item->receipt }}</td>
              <td>{{ $item->payment }}</td>
              <td>{{ $item->created_at->format('d M Y h:i:s A') }}</td>
              <td>
                @if($item->adminWid != null)
                 @if($item->adminWattet->confirm ==1)
                    <span class="badge badge-success">Success</span> 
                  @elseif($item->adminWattet->confirm ==2)
                    <span class="badge badge-secondary">Cancel</span> 
                  @else
                    <span class="badge badge-warning">Pending</span>                      
                  @endif
                @endif
              </td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-body -->        
      </div>
    <!-- /.content -->
  </div>
 @endsection