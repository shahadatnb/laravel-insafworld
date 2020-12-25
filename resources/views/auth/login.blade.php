@extends('frontend.layout')
@section('content')
<div id="banner" class="banner full-screen-mode parallax" style="height:100px !important;min-height:100px !important;">
</div>
<div id="login" class="reservations-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="form-reservations-box">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                            <h2 class="block-title text-center">Login</h2>
                        </div>
                        <h4 class="form-title">Please Login Now</h4>
                        {{-- <p>PLEASE FILL OUT ALL REQUIRED* FIELDS. THANKS!</p> --}}

                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-box">
                                    <input id="email" type="text" placeholder="Username" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-box">
                                    <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>                            

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reserve-book-btn text-left">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reserve-book-btn text-center">
                                    <button class="hvr-underline-from-center" type="submit" value="SEND" id="submit">Login </button>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reserve-book-btn text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?</a>
                                </div>
                            </div>
                            <!-- end col -->
                        </form>
                        <!-- end form -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end reservations-box -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end reservations-main -->
@endsection
