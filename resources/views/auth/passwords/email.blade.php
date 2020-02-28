<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>ADM - Admin Panel v3 - Şifremi Unuttum</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

<!-- Begin page -->
<div class="accountbg"></div>
<div class="home-btn d-none d-sm-block">
    <a href="{{ route('login') }}" class="text-white" title="Ana Sayfa"><i class="fas fa-home h2"></i></a>
</div>

<div class="wrapper-page">
    <div class="card card-pages shadow-none">

        <div class="card-body">
            <h5 class="font-18 text-center">Şifremi Unuttum</h5>

            <form class="form-horizontal m-t-30" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label for="email">Email Adresiniz</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="E-Mail Adresiniz" required>
                    </div>
                </div>

                <div class="form-group text-center m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Şifremi Gönder</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- END wrapper -->
</body>

</html>
