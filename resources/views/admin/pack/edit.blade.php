@extends('layouts.master')
@section('title','Packeg')
@section('content')
<div class="content-wrapper">

    
      {!! Form::model($packeg,['route'=>['packs.update',$packeg->id],'method'=>'PUT' ]) !!}
      <!-- Default box -->
      <div class="card">        
        <div class="card-body"> 
          @include('layouts._message')
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('title','Title') }}
            </div>
            <div class="col-md-8">
              {{ Form::text('title',null,['class'=>'form-control']) }}             
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('amount','amount') }}
            </div>
            <div class="col-md-8">
              {{ Form::text('amount',null,['class'=>'form-control']) }}             
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('payment','payment') }}
            </div>
            <div class="col-md-8">
              {{ Form::text('payment',null,['class'=>'form-control']) }}             
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('exp','Max %') }}
            </div>
            <div class="col-md-8">
              {{ Form::text('exp',null,['class'=>'form-control']) }}             
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              {{ Form::label('minWithdraw','Min Withdraw') }}
            </div>
            <div class="col-md-8">
              {{ Form::text('minWithdraw',null,['class'=>'form-control']) }}             
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              {{ Form::submit('Update', ['class'=>'btn btn-primary btn-block']) }}             
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