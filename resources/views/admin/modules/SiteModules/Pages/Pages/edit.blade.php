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
                        <h4 class="page-title">İçerikler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pages') }}">Sayfalar</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/pages/welcome') }}">İçerikler</a></li>
                            <li class="breadcrumb-item active">İçerik Düzenle</li>
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
                            <form action="{{ route('pages.update',  $page->id) }}" method="post">
                                <input name="_method" value="PUT" type="hidden">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            {!! $categories !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Başlık</label>
                                    <input name="name" class="form-control" placeholder="Başlık" value="{{ $page->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Dış Url</label>
                                    <input name="section_url" class="form-control" value="{{ $page->section_url }}" placeholder="Dış Url Adresi (https://www.ornek.com)">
                                </div>

                                <div class="form-group">
                                    <label>İçerik</label>
                                    <textarea name="content" id="summernote" required>{{ $page->content }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Seo Açıklama</label>
                                    <input name="seo_desc" maxlength="160" class="form-control" id="placement" value="{{ $page->seo_desc }}" placeholder="Seo Açıklaması">
                                </div>

                                <div class="form-group">
                                    <label>Seo Anahtar Kelimeler</label>
                                    <input name="seo_keywords" maxlength="200" class="form-control" id="placement" value="{{ $page->seo_keywords }}" placeholder="Seo Anathar Kelimeler virgül ile ayrılmış">
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Sıra No</label>
                                            <input name="sorting" class="form-control" value="{{ $page->sorting }}" placeholder="Sıra No">
                                        </div>

                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_status($page->status) !!}
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
                                        <a href="{{ url('admin/pages/welcome') }}" class="btn btn-secondary waves-effect m-l-5">
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
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/lang/summernote-tr-TR.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('form').parsley();

            $('input#placement').maxlength({
                alwaysShow: true,
                placement: 'top-left',
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });

            $('input#keywords').maxlength({
                alwaysShow: true,
                placement: 'top-left',
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });

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