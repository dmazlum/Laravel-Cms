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
                        <h4 class="page-title">Panel Kullanıcıları</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item active">Panel Kullanıcıları</li>
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
                                <a href="{{ route('users.create') }}" class="btn btn-success float-right m-b-20"><span class="fa fa-plus"></span> Yeni Kullanıcı</a>
                            </div>
                            <div class="clearfix"></div>
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Adı Soyadı</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Rolü</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge badge-{{ $user->role == 'admin' ? 'success': 'danger'}}">{{ $user->role == 'admin' ? 'Yönetici': 'Kullanıcı'}}</span></td>
                                        <td>
                                            <span class="badge badge-{{ $user->active == 1 ? 'success': 'danger'}}">{{ $user->active == 1 ? 'Aktif': 'Deaktif'}}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary btn-sm" title="Düzenle"><span class="fa fa-pen"></span></a>
                                            <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-outline-danger btn-sm" title="Sil" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $user->id }}').submit();"><span class="fa fa-trash"></span></a>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
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