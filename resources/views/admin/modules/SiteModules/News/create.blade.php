@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Duyurular</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Duyurular</a></li>
                            <li class="breadcrumb-item active">Duyuru Ekle</li>
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
                            <form action="{{ route('news.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Başlık</label>
                                    <input name="subject" class="form-control" placeholder="Başlık" value="{{ old('subject') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>İçerik</label>
                                    <textarea name="content" id="summernote" required>{{ old('content') }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-3">
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
                                        <a href="{{ url('admin/news') }}" class="btn btn-secondary waves-effect m-l-5">
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
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/lang/summernote-tr-TR.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('form').parsley();

            $('#summernote').summernote({
                height: 250,
                placeholder: 'Sayfa İçeriği',
                lang: 'tr-TR',
                minHeight: null,
                maxHeight: null,
                focus: false
            });
        });
    </script>
@endsection