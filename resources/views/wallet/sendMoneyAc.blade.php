@extends('layouts.master')
@section('title','Send Money Another Account')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-yellow with-border">
      <strong class="card-title">Send Money Another Account</strong>
    </div>
  <div class="card-body">
 @include('layouts._message')
  
  {!! Form::open(['route'=>'sendMoneyAc','method'=>'POST','class'=>'form-horizontal']) !!}
  <div class="row form-group">
    <div class="col-md-2">
      {{ Form::label('username','Username') }}
    </div>
    <div class="col-md-4">
      {{ Form::text('username',null,['class'=>'form-control','required'=>'']) }} 
      {{ Form::hidden('wType',$wallet) }} 
    </div>
    <div class="col-md-2">
      {{ Form::label('payment','Amount') }}
    </div>
    <div class="col-md-4">
      {{ Form::text('payment',null,['class'=>'form-control','required'=>'']) }}
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      {{ Form::label('remark','Remark') }}
    </div>
    <div class="col-md-4">
      {{ Form::text('remark',null,['class'=>'form-control']) }}
    </div>
    <div class="col-md-6">
      {{ Form::submit('Transtfer',array('class'=>'btn btn-yellow')) }}
    </div>
  </div>
 {!! Form::close() !!}
</div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    <!-- /.content -->
  </div>
 @endsection
