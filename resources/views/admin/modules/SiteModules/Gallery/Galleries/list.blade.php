@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item active">Galeriler</li>
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
                                <a href="{{ route('gallery.create') }}" class="btn btn-success float-right m-b-20"><span class="fa fa-plus"></span> Yeni Fotoğraf</a>
                            </div>
                            <div class="clearfix"></div>
                            <p>
                                Lütfen fotoğraf eklemek istediğiniz galeriyi seçiniz.
                            </p>
                            @foreach($categories as $category)
                                <div class="col-3">
                                    <a href="">
                                        <img class="img-thumbnail" style="width: 200px; height: 200px;" src="{{ asset('uploads/gallery/'. $category->slug) }}/{{ $category->photo }}" data-holder-rendered="true">
                                    </a>
                                    <h6 class="text-center">{{ $category->name }}</h6>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

@endsection