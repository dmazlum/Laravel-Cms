@extends('admin/layouts.app')
@section('module_css')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Galeriler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.gallery') }}">Galeri</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/gallery/welcome') }}">İçerikler</a></li>
                            <li class="breadcrumb-item active">İçerik Ekle</li>
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
                            <div class="col-md-12">
                                <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm float-right m-b-20 m-r-5"><span class="fa fa-chevron-left"></span> Geri</a>
                            </div>
                            <div class="clearfix"></div>
                            <h2>
                                {{ $categoryName[0]['name'] }} Galerisi
                            </h2>
                            <p>
                                Yeni fotoğraf eklemek için lütfen aşağıdaki alana fotoğraflarınızı sürükleyin yada
                                üzerine tıklayın. Fotoğraflarınızı seçtikten sonra <strong>Yükle</strong> butonuna
                                basınız.
                            </p>
                            <p class="text-danger">Maks dosya boyutu : 3MB olmalıdır</p>

                            <input name="file" type="file" class="file-multiple" multiple/>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
    <script src="{{ asset('assets/plugins/file-input/js/fileinput.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-input/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-input/js/locales/tr.js') }}"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // File upload
            $(".file-multiple").fileinput({
                theme: 'fas',
                uploadUrl: '{{ route('gallery.store') }}',
                uploadAsync: true,
                overwriteInitial: false,
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                @if(!empty($categoryName[0]))
                uploadExtraData: function (previewId, index) {
                    return { catId: <?php echo $categoryName[0]['id'] ?>, path: "<?php echo $categoryName[0]['slug'] ?>", key: index }
                },
                @endif
                maxFileSize: 3000,
                showUpload: true,
                showBrowse: false,
                showCaption: false,
                browseOnZoneClick: true,
                showUploadedThumbs: false,
                removeClass: "btn btn-danger",
                uploadClass: "btn btn-success",
                language: 'tr',
                autoOrientImage: false
            });

            $('.file-multiple').on('filebatchuploadcomplete', function() {
                location.href = "{{ $backUrl }}";
            });

        });
    </script>
@endsection