@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/tag-input/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Panel Kullanıcıları</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Panel Kullanıcıları</a></li>
                            <li class="breadcrumb-item active">Düzenle</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->
            <div class="row">
                <div class="col-12">
                    @include('inc.messages')
                    <div class="card m-b-30">

                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                <input name="_method" value="PUT" type="hidden">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Adı Soyadı</label>
                                    <input name="name" type="text" class="form-control" required placeholder="Adı Soyadı" value="{{ $user->name }}"/>
                                </div>

                                <div class="form-group">
                                    <label>Kullanıcı Adı</label>
                                    <div>
                                        <input name="email" type="email" class="form-control" required
                                               parsley-type="email" placeholder="Kullanıcı Adı" value="{{ $user->email }}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Şifre</label>
                                    <p class="text-muted m-b-15">
                                        Sadece şifre değişikliğinde giriş yapınız
                                    </p>
                                    <div>
                                        <input name="password" type="password" id="pass2" class="form-control" placeholder="Şifre"/>
                                    </div>
                                    <div class="m-t-10">
                                        <input type="password" class="form-control" data-parsley-equalto="#pass2" placeholder="Şifreniz yeniden girin"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Kullanıcı Rolü</label>
                                            <div>
                                                <select name="role" class="form-control">
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_role($user->role) !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kullanıcı İzinleri</label>
                                    <div>
                                        <input name="permissions" id="permission" type="text" class="form-control" required>
                                        <p class="text-muted m-t-10">
                                            Yeni izinleri aşağıdan seçebilirsiniz
                                        </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label>İzin Ekle</label>
                                            <div>
                                                <select id="permissions" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                    @foreach($allModules as $allModule)
                                                        <option value="{{ $allModule->sname }}">{{ $allModule->module_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-1 m-t-30">
                                            <button class="btn btn-success btn-sm" id="addPermission">Ekle</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="active" class="form-control">
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_status($user->active) !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            Güncelle
                                        </button>
                                        <a href="{{ route('admin.users') }}" class="btn btn-secondary waves-effect m-l-5">
                                            İptal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
    <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tag-input/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // Form
            $('form').parsley();

            // Tag Inputs
            let elt = $('#permission');

            elt.tagsinput({
                itemValue: 'value',
                itemText: 'text',
                tagClass: 'badge badge-primary',
                freeInput: false,
                delimiter: ',',
                allowDuplicates: false
            });

            $('#addPermission').on('click',function (e) {
                e.preventDefault();
                var $this = $('#permissions option:selected');

                if ($this.val() !== '') {
                    elt.tagsinput('add', {"value": $this.val(), "text": $this.text()});
                }
            });

            @foreach($modules as $key => $value)
elt.tagsinput('add', {"value":  "{{ $modules[$key]['sname'] }}", "text": "{{ $modules[$key]['module_name'] }}"});
            @endforeach

        });
    </script>
@endsection