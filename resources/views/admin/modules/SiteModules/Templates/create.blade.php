@extends('admin/layouts.app')
@section('module_css')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Şablonlar</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.templates') }}">Şablonlar</a></li>
                            <li class="breadcrumb-item active">Şablon Ekle</li>
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
                            <form action="{{ route('templates.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>İlgili Kategori</label>
                                    <div class="row">
                                        <div class="col-4">
                                            {!! $dropdown !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Şablon Başlığı</label>
                                    <div>
                                        <input name="theme_name" type="text" class="form-control" required placeholder="Şablon Başlığı" value="{{ old('theme_name') }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Şablon Kodu</label>
                                    <div>
                                        <textarea name="theme_context" class="form-control" rows="10" placeholder="Şablon Kodu" required>{{ old('theme_context') }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="active" class="form-control" required>
                                                    <option value="">Lütfen Seçiniz</option>
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Deaktif</option>
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
                                        <a href="{{ route('admin.templates') }}" class="btn btn-secondary waves-effect m-l-5">
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
            // Form
            $('form').parsley();
        });
    </script>
@endsection