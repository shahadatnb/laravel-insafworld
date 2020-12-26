@php use App\User; @endphp
@extends('layouts.master')
@section('title','Level')
@section('stylesheet')
  <!-- hierarchy-view -->
  {!! Html::style('public/admin/assets/css/hierarchy-view.css') !!}
@endsection
@section('content')
<div class="content-wrapper">  

      <!-- Default box -->
      <div class="card" style="background-color: rgba(0,0,0,.9);">
        <div class="card-header with-border">
        <div class="card-body basic-style">
          <div class="hv-container">
            <div class="hv-wrapper">

                <!-- Key component -->
                <div class="hv-item">
                    <div class="hv-item-parent">
                        <p class="simple-card text-center" data-toggle="tooltip" data-html="true" title="Username: <em>{{ $members->username }}</em><br>Name: <em>{{ $members->name }}</em><br>Email: <u>{{ $members->email }}</u>">
<img width="50" src="{{ url('/')}}/public/admin/images/avatar.png" alt=""> <br>
                          <span>Sales Velue 1:{{ App\User::myChildLR($members->id, 1) }}</span> - <span>Sales Velue 2:{{ App\User::myChildLR($members->id, 2) }}</span>
                        </p>
                    </div>

                        @if(count($members->childs))

                            @include('pages.levelTreeChild',['childs' => $members->childs, 'defth' => 1])

                        @endif

                </div>

            </div>
          </div>
          
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    
    <!-- /.content -->
  </div>
</div>
 @endsection