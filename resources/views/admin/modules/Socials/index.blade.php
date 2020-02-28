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
                        <h4 class="page-title">Sosyal Medya</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item active">Sosyal Medya</li>
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
                                <a href="{{ route('socials.create') }}" class="btn btn-success float-right m-b-20"><span class="fa fa-plus"></span> Yeni Kayıt</a>
                            </div>
                            <div class="clearfix"></div>
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Adı</th>
                                    <th>Bağlantı Adresi</th>
                                    <th>Ikon</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($socials as $social)
                                    <tr>
                                        <td>{{ $social->social_name }}</td>
                                        <td>{{ $social->social_url }}</td>
                                        <td><span class="fab {{ $social->icon }}"></span></td>
                                        <td>
                                            <span class="badge badge-{{ $social->status == 1 ? 'success': 'danger'}}">{{ $social->status == 1 ? 'Aktif': 'Deaktif'}}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('socials.edit', $social->id) }}" class="btn btn-outline-secondary btn-sm" title="Düzenle"><span class="fa fa-pen"></span></a>
                                            <a href="{{ route('socials.destroy', $social->id) }}" class="btn btn-outline-danger btn-sm" title="Sil" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $social->id }}').submit();"><span class="fa fa-trash"></span></a>
                                            <form id="delete-form-{{ $social->id }}" action="{{ route('socials.destroy', $social->id) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input name="_method" value="DELETE" type="hidden">
                                            </form>
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
                "info": false,
                "language": {
                    "url": "{{ asset('assets/plugins/datatables/Turkish.json') }}"
                }
            });
        });
    </script>
@endsection