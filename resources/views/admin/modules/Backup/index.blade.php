@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Yedekleme</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item active">Yedekleme</li>
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

                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Dil</th>
                                    <th>ISO Kodu</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($languages as $language)
                                    <tr>
                                        <td>{{$language->text}}</td>
                                        <td>{{$language->iso_code}}</td>
                                        <td>
                                            <span class="badge badge-{{$language->status == 1 ? 'success': 'danger'}}">{{$language->status == 1 ? 'Aktif': 'Deaktif'}}</span>
                                        </td>
                                        <td>
                                            @if($language->status == 1)
                                                <a href="/admin/languages/{{$language->id}}/edit"
                                                   class="btn btn-danger btn-rounded btn-condensed btn-sm"
                                                   title="Deaktif"><span class="fa fa-power-off"></span></a>
                                            @else
                                                <a href="/admin/languages/{{$language->id}}/edit"
                                                   class="btn btn-success btn-rounded btn-condensed btn-sm"
                                                   title="Aktif"><span class="fa fa-check"></span></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

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
    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "searching": false,
                "paging": false,
                "info": false,
                "language": {
                    "url": "{{ asset('assets/plugins/datatables/Turkish.json') }}"
                }
            });
        });
    </script>
@endsection