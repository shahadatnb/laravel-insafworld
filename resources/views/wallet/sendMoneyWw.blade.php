 @include('layouts._message')
  <h3 class="card-header text-center">Transfer To Withdraw wallet</h3>
  {!! Form::open(['route'=>'sendMoneyWw','method'=>'POST','class'=>'form-horizontal mt-2']) !!}
    {{ Form::hidden('wType',$wallet) }} 
  <div class="row form-group">
    <div class="col-md-2">
      {{ Form::label('payment','Amount') }}
    </div>
    <div class="col-md-4">
      {{ Form::text('payment',null,['class'=>'form-control','required'=>'']) }}
    </div>
    <div class="col-md-2">
      {{ Form::label('remark','Remark') }}
    </div>
    <div class="col-md-4">
      {{ Form::text('remark',null,['class'=>'form-control']) }}
    </div>
  </div>
  <div class="row form-group">
    <div class="col">
    {{ Form::submit('Transfer To Withdraw wallet',array('class'=>'btn-block btn btn-info')) }}</div>
  </div>
 {!! Form::close() !!}

