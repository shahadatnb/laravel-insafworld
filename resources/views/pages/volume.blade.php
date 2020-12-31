@extends('layouts.master')
@section('title','Generation Chart')
@section('stylesheet')
@endsection
@section('content')
<div class="content-wrapper">   

      <!-- Default box -->
      <div class="card">
        <div class="card-body">
            <div class="card text-white bg-flat-color-1">
              <div class="card-body">
                  
Name: {{$member->name}} <br>
            Usernme: {{$member->username}} <br>
            Email: {{$member->email}} <br>
            Packeg: {{$member->packeg->title}} <br>
              </div>
            
          </div>

          <div class="row">
            @foreach($member->childs as $m)
            <div class="col-6">
              <div class="card text-white bg-flat-color-3">
                <div class="card-body">
                    

              Name: {{$m->name}} <br>
              Username: {{$m->username}} <br>
              Email: {{$m->email}} <br>
              Packeg: {{$m->packeg->title}} <br>
              <a class="btn btn-primary" href="{{route('volume',$m->id)}}">Details</a>
                </div>

              </div>
              
            </div>
            @endforeach
          </div>
          
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    
    <!-- /.content -->
  </div>
 @endsection
