@extends('layouts.master')
@section('title',$walletInfo['title'])
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    

      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-yellow with-border">
          <strong class="card-title">Your {{$walletInfo['title']}}</strong>
          @if(array_has($walletInfo,'dailyWallet')), Balance ${{ $balance }} @endif
        </div>
        <div class="card-body">
          <p>Transaction List</p>
          <table class="table table-striped">
            <tr>
              <th>Remark</th>
              <th>Receipt</th>
              <th>Payment</th>
              <th>Date</th>
            </tr>
            @foreach ($transaction as $member)
            <tr>
              <td>{{ $member->remark }}</td>
              <td>{{ $member->receipt }}</td>
              <td>{{ $member->payment }}</td>
              <td>{{ $member->created_at->format('d M Y h:i:s A') }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    
    <!-- /.content -->
  </div>
 @endsection