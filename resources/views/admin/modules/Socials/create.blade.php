@extends('admin/layouts.app')
@section('module_css')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sosyal Medya</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.socials') }}">Sosyal Medya</a></li>
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
                            <form action="{{ route('socials.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Adı</label>
                                    <input name="social_name" type="text" class="form-control" required placeholder="Adı" value="{{ old('social_name') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>Bağlantı Adresi</label>
                                    <div>
                                        <input name="social_url" type="url" class="form-control" required
                                               parsley-type="url"
                                               placeholder="Bağlantı Adresi"
                                               value="{{ old('social_url') }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Ikon</label>
                                            <div>
                                                <select name="icon" class="form-control" required>
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_icons() !!}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_status(1) !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            Gönder
                                        </button>
                                        <a href="{{ route('admin.socials') }}" class="btn btn-secondary waves-effect m-l-5">
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
    <script>
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>
@endsection