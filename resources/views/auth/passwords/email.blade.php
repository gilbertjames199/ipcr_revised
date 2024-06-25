{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Sign In - IPCR</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('js/app.js') }}"></script>
</head>

<body class="app">
    <div class="peers ai-s fxw-nw h-100vh">
        <div class="peers ai-s fxw-nw h-100vh">
            <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv"
                style='background-image:url("images/bg.jpg"); background-size:100% 100%'>
                <div class="row mt-3 ms-3" style="color: rgb(52, 52, 52); display: block;">
                    <div class="col-md-6">
                        <h1 class="strokeme display-5" style="font-weight: bold; color: #0b4497; font-size: 50px;">
                            e-Performance Management System
                        </h1>
                    </div>
                </div>
                <div>

                    <div class="row text-center pos-a centerXY">
                        <div>
                            <!--<img class="mw-50" src="images/logo.png" alt="">-->
                            &nbsp;&nbsp;<img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid"
                                style="width:250px; height:250px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 scrollable pos-r"
                style="min-width:320px; background-color: #0b4497 ; color: white; !important">
                <div class="row text-center" id="mobile-logo">
                    <div class="col-offset-5 mb-1">
                        <img class="img-fluid" src="images/logo.png" alt="">
                        <h3>WELCOME</h3>
                    </div>

                </div>
                {{-- <div class="hide_for_mobile">
                    <h4 class="fw-300 mB-10 font-weight-bold" style="font-weight: bold !important; font-color: white">
                        WELCOME
                    </h4>

                </div> --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    <p>Note: <i>If you haven't received the email, please check your <b>spam</b> folder</i></p>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger" style="margin-bottom: unset; padding: .3rem;">
                        @foreach ($errors->all() as $message)
                            <small class="text-danger">
                                <strong>
                                    <p style="margin-bottom: unset;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            fill="currentColor"
                                            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"
                                            viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                </strong>
                            </small>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">

                    @csrf

                    <div class="mb-3">

                        <label class="text-normal text-light form-label">Email: </label>

                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}" autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="">
                        <div class="peers ai-c jc-sb fxw-nw">
                            {{-- <div class="peer">
                                <div class="checkbox checkbox-circle checkbox-info peers ai-c"><input type="checkbox"
                                        id="inputCall1" name="inputCheckboxesCall" class="peer"> <label
                                        for="inputCall1" class="peers peer-greed js-sb ai-c form-label"><span
                                            class="peer peer-greed">Remember Me</span></label></div>
                            </div> --}}
                            <div class="peer">
                                {{-- <button type="submit" class="btn btn-primary btn-color">Enter</button> --}}
                                <button type="submit" class="btn btn-primary btn-color">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                                {{-- <a href="/login">login here</a> --}}
                                <hr>
                                <p></p>
                                <p class="text-white" href="/login">
                                    Go back to <a href="login">login</a> page
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- @endsection --}}
