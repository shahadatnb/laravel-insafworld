@extends('layouts.master')
@section('content')
<div class="content-wrapper">   
    <div class="card">
      <div class="card-header bg-info with-border text-center">
        <strong class="card-title text-light">Your Information</strong>
      </div>
      <div class="card-body">
      @include('layouts._message')
        {!! Form::open(['route'=>'newMember','method'=>'POST']) !!}        
          @include('auth.reg_field')
          <input type="hidden" name="referralId" value="{{ Auth::user()->id }}" required>
        <div class="row">
          <div class="col-md-12"> <br>
          {{ Form::submit('Submit',array('class'=>'btn btn-yellow')) }}</div>
        </div>
       {!! Form::close() !!}
      </div>
    </div>
    
    <!-- /.content -->
  </div>
 @endsection
