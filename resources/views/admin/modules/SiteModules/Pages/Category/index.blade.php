@extends('admin.layouts.app')
@section('module_css')
    <link href="{{asset('assets/plugins/nestable/jquery.nestable.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Sayfalar</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.pages')}}">Sayfalar</a></li>
                            <li class="breadcrumb-item active">Kategoriler</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->
            <div class="row">
                <div class="col-lg-12">
                    @include('inc.messages')
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="col-md-12">
                                <a href="{{ route('categories.create') }}" class="btn btn-success float-right m-b-20"><span class="fa fa-plus"></span> Yeni Kategori</a>
                            </div>
                            <h4 class="mt-0 header-title">Kategoriler</h4>
                            <p class="sub-title">
                                Kategorileri taşıyarak sıralayabilirsiniz. <span class="badge badge-danger">Kırmızı işaretli</span> olanlar Deaktif durumdadır.
                            </p>
                            <div class="custom-dd dd" id="nestable">
                                {!! $menu !!}
                            </div>

                            <div class="alert alert-success" id="success-indicator" style="display:none;">
                                <span class="fa fa-check"></span> Sıralama başarıyla değiştirilmiştir.
                            </div>
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
    <script src="{{ asset('assets/plugins/nestable/jquery.nestable.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('.dd').nestable({
                dropCallback: function (details) {

                    var order = new Array();

                    $("li[data-id='" + details.destId + "']").find('ol:first').children().each(function (index, elem) {
                        order[index] = $(elem).attr('data-id');
                    });

                    if (order.length === 0) {
                        var rootOrder = new Array();
                        $("#nestable > ol > li").each(function (index, elem) {
                            rootOrder[index] = $(elem).attr('data-id');
                        });
                    }

                    $.post('{{ url("admin/categories/menu/") }}',
                        {
                            source: details.sourceId,
                            destination: details.destId,
                            order: JSON.stringify(order),
                            rootOrder: JSON.stringify(rootOrder)
                        },
                        function (data) {
                        })
                        .done(function () {
                            $("#success-indicator").fadeIn(100).delay(1000).fadeOut();
                        })
                        .fail(function () {
                        })
                        .always(function () {
                        });
                }
            });

        });
    </script>
@endsection