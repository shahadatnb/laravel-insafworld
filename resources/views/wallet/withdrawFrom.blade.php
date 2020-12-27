@extends('layouts.master')
@section('title',$title)
@section('content')
<div class="content-wrapper">
<div class="card">
    <div class="card-header text-center">
      <strong>Withdraw balance</strong>
    </div>
    <div class="card-body card-block">
      @include('layouts._message')
      {!! Form::open(['route'=>'withdrawBalance','method'=>'POST','class'=>'form-horizontal']) !!}
        {{ Form::hidden('wType',$wallet) }}
         <div class="row form-group">
          {{-- <div class="col-3">{{ Form::label('payment','Amount') }}</div> --}}
          <div class="col-9">{{ Form::text('payment',null,['class'=>'form-control','required'=>'','placeholder'=>'Amount']) }}</div>                              
        </div>
        <div class="row form-group">
          {{-- <div class="col-3">{{ Form::label('bankName','Bank Name') }}</div> --}}
          <div class="col-9">{{ Form::select('bankName',$bankName,null,['class'=>'form-control','required'=>'','placeholder'=>'Bank Name']) }}</div>                
        </div>
        <div class="row form-group">
          {{-- <div class="col-3">{{ Form::label('accountNo','Account No') }}</div> --}}
          <div class="col-9">{{ Form::text('accountNo',null,['class'=>'form-control','required'=>'','placeholder'=>'Account No']) }}</div> 
        </div>
        <div class="row form-group">
          {{-- <div class="col-3">{{ Form::label('remark','Remark') }}</div> --}}
          <div class="col-9">{{ Form::text('remark',null,['class'=>'form-control','placeholder'=>'Remark']) }}</div>              
        </div>
        <div class="row form-group">
          {{ Form::submit('Send',array('class'=>'btn btn-yellow')) }}
        </div>

      {!! Form::close() !!} 
    </div>
</div>
  </div>
 @endsection