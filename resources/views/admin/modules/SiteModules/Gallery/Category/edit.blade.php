@extends('admin.layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Galeri Kategorileri</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.gallery')}}">Galeri</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.galleries.categories') }}">Kategoriler</a></li>
                            <li class="breadcrumb-item active">Düzenle</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('galleryCategory.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                <input name="_method" value="PUT" type="hidden">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Kategori Bölümü</label>
                                    {!! $categories !!}
                                </div>
                                <div class="form-group">
                                    <label>Kategori Adı</label>
                                    <input name="name" type="text" class="form-control" placeholder="Kategori Adı" value="{{ $category->name }}" required/>
                                </div>
                                <div class="form-group">
                                    <label>İçerik</label>
                                    <textarea name="content" id="summernote">{{ $category->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kategori Fotoğrafı</label>
                                    <input name="file" type="file" class="file-simple"/>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Sıra No</label>
                                            <input name="sorting" class="form-control" value="{{ $category->sorting }}" placeholder="Sıra No">
                                        </div>
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Lütfen Seçiniz</option>
                                                    {!! \App\Helpers\DropDown::get_status($category->status) !!}
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
                                        <a href="{{ route('admin.galleries.categories') }}" class="btn btn-secondary waves-effect m-l-5">
                                            İptal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
    <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/lang/summernote-tr-TR.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-input/js/fileinput.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-input/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-input/js/locales/tr.js') }}"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('form').parsley();

            $('#summernote').summernote({
                height: 150,
                placeholder: 'Kısa Açıklama',
                lang: 'tr-TR',
                minHeight: null,
                maxHeight: null,
                focus: false
            });

            // File upload
            $(".file-simple").fileinput({
                theme: 'fas',
                @if ($category->photo !='')
                overwriteInitial: true,
                initialPreviewAsData: true,
                initialPreview: [
                    '{{ asset('uploads/gallery'). '/'.$category->slug.'/'. $category->photo }}'
                ],
                initialPreviewConfig: [
                    {caption: "{{ $category->photo }}", url: "{{ url('/admin/gallery/galleryCategory/deleteSinglePhoto') }}", key: "{{ $category->id }}"},
                ],
                @endif
                allowedFileExtensions: ['jpg', 'png'],
                maxFileSize: 1000,
                showUpload: false,
                showBrowse: false,
                showCaption: false,
                browseOnZoneClick: true,
                browseClass: "btn btn-danger",
                maxFileCount: 1,
                language: 'tr',
                autoOrientImage: false
            });

        });
    </script>
@endsection