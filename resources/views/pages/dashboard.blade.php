@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col">
    <div class="alert alert-info" role="alert">
      <marquee behavior="" direction="">{{ settingValue('backend_msg') }}</marquee>   
    </div>    
  </div>
</div>
<div class="row">
  <div class="col-sm-6 col-lg-4">
    <div class="card text-white bg-flat-color-{{$percent['bg']}}">
      <div class="card-body">
          <div class="stat-widget-one">
              <div class="stat-icon dib">
                <i class="ti-money text-{{$percent['bg']}} border-"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-digit">{{$percent['balance']}}%</div>
                  <div class="stat-text mt-2 text-center">{{$percent['title']}}</div>
              </div>
          </div>
      </div>
    </div>
  </div>
@foreach($wallets2 as $item)
  <div class="col-sm-6 col-lg-4">
    <div class="card text-white bg-flat-color-{{$item['bg']}}">
      <div class="card-body">
          <div class="stat-widget-one">
              <div class="stat-icon dib">
                <i class="ti-money text-{{$item['bg']}} border-{{$item['bg']}}"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-digit">{{$item['balance']}}</div>
                  <div class="stat-text mt-2 text-center">{{$item['title']}}</div>
              </div>
          </div>
      </div>
    </div>
      {{-- <div class="card text-white bg-flat-color-{{$item['bg']}}">
          <div class="card-body">
              <div class="card-left pt-1 float-left">
                  <h3 class="mb-0 fw-r">
                      {{$item['balance']}}
                  </h3>
                  <p class="text-light mt-1 m-0">{{$item['title']}}</p>
              </div>

              <div class="card-right float-right text-right">
                  <i class="icon fade-5 icon-lg pe-7s-cash"></i>
              </div>

          </div>

      </div> --}}
  </div>  
  @endforeach
  @foreach($wallets as $item)
  <div class="col-sm-6 col-lg-4">
    <div class="card text-white bg-flat-color-{{$item['bg']}}">
      <div class="card-body">
          <div class="stat-widget-one">
              <div class="stat-icon dib">
                <i class="ti-money text-{{$item['bg']}} border-{{$item['bg']}}"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-digit">{{$item['balance']}}</div>
                  <div class="stat-text mt-2 text-center">{{$item['title']}}</div>
              </div>
          </div>
      </div>
    </div>      
  </div>
  @endforeach
</div>
{{-- <div class="card">
  <div class="card-header">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
  </div>
  <div class="card-body">
    <div class="row">
    	@foreach($wallets as $item)
      <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card bg-{{$item['bg']}} text-white shadow">
          <div class="card-body text-center">
            {{$item['title']}}
            <div class="text-white"><i class="fa fa-dollar"></i>{{$item['balance']}}</div>
          </div>
        </div>
      </div>
    	@endforeach
    </div>
  </div>
</div> --}}
 @endsection