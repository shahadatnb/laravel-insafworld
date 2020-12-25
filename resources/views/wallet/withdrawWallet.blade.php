@extends('layouts.master')
@section('title',$walletName)
@section('content')
<div class="content-wrapper">
      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-info with-border">
          <strong class="card-title text-light">Your {{$walletName}} Balance <i class="fa fa-dollar"></i>{{ $balance }}</strong>
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
        @php
          $accounts = [
            'bKash'=>'bKash',
            'Rocket'=>'Rocket',
            'Nagad'=>'Nagad',
            'Bank '=>'Bank',
            'Perfect money'=>'Perfect money',
            'PayPal'=>'PayPal',
            'btc'=>'btc',
          ];
        @endphp
      </div>
      <!-- /.box -->
      <div class="card">
        <div class="card-header text-center">
          <strong>Withdraw balance</strong>
        </div>
        <div class="card-body card-block">
          @include('layouts._message')
          {!! Form::open(['route'=>'withdrawBalance','method'=>'POST','class'=>'form-horizontal']) !!}
             <div class="row form-group">
              <div class="col-3">{{ Form::label('payment','Amount') }}</div>
              <div class="col-9">{{ Form::text('payment',null,['class'=>'form-control','required'=>'']) }}</div>                              
            </div>
            <div class="row form-group">
              <div class="col-3">{{ Form::label('bankName','Bank Name') }}</div>
              <div class="col-9">{{ Form::select('bankName',$accounts,null,['class'=>'form-control','required'=>'','placeholder'=>'Bank Name']) }}</div>                
            </div>
            <div class="row form-group">
              <div class="col-3">{{ Form::label('accountNo','Account No') }}</div>
              <div class="col-9">{{ Form::text('accountNo',null,['class'=>'form-control','required'=>'']) }}</div>              
            </div>
            <div class="row form-group">
              <div class="col-3">{{ Form::label('remark','Remark') }}</div>
              <div class="col-9">{{ Form::text('remark',null,['class'=>'form-control']) }}</div>              
            </div>
            <div class="row form-group">
              {{ Form::submit('Send',array('class'=>'btn-block btn btn-info')) }}
            </div>

          {!! Form::close() !!} 
        </div>
    </div>
    <!-- /.content -->
  </div>
 @endsection