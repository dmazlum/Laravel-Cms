<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>ADM - Admin Panel v3</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

<!-- Begin page -->
<div class="accountbg"></div>

<div class="wrapper-page">
    <div class="card card-pages shadow-none">

        <div class="card-body">
            <div class="text-center m-t-0 m-b-15">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="24">
            </div>
            <h5 class="font-18 text-center">Lütfen aşağıdaki bilgileri giriniz</h5>

            <form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="col-md-12">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-12">
                        <label for="email">E-Mail Adresiniz</label>
                        <input name="email" id="email" class="form-control" type="text" required=""
                               placeholder="E-Mail Adresiniz" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label for="password">Şifreniz</label>
                        <input name="password" id="password" class="form-control" type="password" required=""
                               placeholder="Şifreniz">
                    </div>
                </div>

                <div class="form-group text-center m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Giriş
                            Yap
                        </button>
                    </div>
                </div>

                <div class="form-group row m-t-30 m-b-0">
                    <div class="col-sm-7">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i>
                            Şifremi Unuttum?</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- END wrapper -->
</body>

</html>