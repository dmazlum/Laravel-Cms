@extends('admin.layouts.app')
@section('module_css')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Kategoriler</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.pages')}}">Sayfalar</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.categories') }}">Kategoriler</a></li>
                            <li class="breadcrumb-item active">Kategori Ekle</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <p>
                                Yeni bir <strong>Ana Kategori</strong> oluşturmak istiyorsanız, lütfen <strong>Kategori Bölümünü</strong> boş bırakınız.
                            </p>
                            <form action="{{ route('categories.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Kategori Bölümü</label>
                                            {!! $categories !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kategori Adı</label>
                                    <input name="name" type="text" class="form-control" placeholder="Kategori Adı" value="{{ old('name') }}" required/>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <div>
                                                <select name="status" class="form-control">
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
                                            Ekle
                                        </button>
                                        <a href="{{ route('admin.categories') }}" class="btn btn-secondary waves-effect m-l-5">
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
    <script>
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>
@endsection