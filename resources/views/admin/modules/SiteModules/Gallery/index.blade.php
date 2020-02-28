@extends('admin/layouts.app')
@section('module_css')

@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Galeri</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item active">Galeriler</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->
            <div class="row m-t-30">
                <div class="col-xl-6 col-md-6">
                    <div class="card pricing-box mt-4">
                        <div class="pricing-icon">
                            <i class="ti-layers-alt bg-success"></i>
                        </div>
                        <div class="pricing-content">
                            <div class="text-center">
                                <h5 class="text-uppercase mt-5">Kategoriler</h5>
                            </div>
                            <div class="mt-4 pt-3 text-center">
                                <a href="{{ route('admin.galleries.categories') }}" class="btn btn-success btn-lg w-100 btn-round">Listele</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-xl-6 col-md-6">
                    <div class="card pricing-box mt-4">
                        <div class="pricing-icon">
                            <i class="ti-menu-alt bg-primary"></i>
                        </div>
                        <div class="pricing-content">
                            <div class="text-center">
                                <h5 class="text-uppercase mt-5">İçerikler</h5>
                            </div>
                            <div class="mt-4 pt-3 text-center">
                                <a href="{{ url('/admin/gallery/welcome') }}" class="btn btn-primary btn-lg w-100 btn-round">Listele</a>
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

@endsection