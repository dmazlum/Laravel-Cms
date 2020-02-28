@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Şablonlar</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Site Modülleri</a></li>
                            <li class="breadcrumb-item active">Şablonlar</li>
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
                                <a href="{{ route('templates.create') }}" class="btn btn-success float-right m-b-20"><span class="fa fa-plus"></span> Yeni Şablon</a>
                            </div>
                            <table class="table table-striped table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Kategori</th>
                                    <th style="width: 15%;">Bölüm Adı</th>
                                    <th>İçerik</th>
                                    <th style="width: 8%">Durum</th>
                                    <th style="width: 7%">İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($templates as $template)
                                <tr>
                                    <td>
                                        <div class="col-12">
                                            {{ $template->category->name }} <button class="btn btn-primary btn-sm float-right" type="button" data-toggle="collapse" data-target="#collapseCat-{{ $template->id }}" aria-expanded="false" aria-controls="collapseCat" title="Değiştir">
                                                <span class="fa fa-exchange-alt"></span>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 collapse" data-id="{{ $template->id }}" id="collapseCat-{{ $template->id }}">
                                                {!! $categories !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="section" data-type="text" data-url="{{ route('templates.update', $template->id) }}" data-placeholder="Bölüm Adı" data-title="Bölüm Giriniz"><strong>{{ $template->theme_name }}</strong></a>
                                    </td>
                                    <td>
                                        <form>
                                            {{ csrf_field() }}
                                            <div class="textarea_modal_widget">
                                                <a href="#" class="context" data-type="textarea" data-url="{{ route('templates.update', $template->id) }}" data-placeholder="İçerik" data-title="İçerik Giriniz">{{ $template->theme_context }}</a>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="#" data-name="status" class="status" data-type="select" data-pk="{{ $template->id }}" data-value="{{ $template->status }}" data-url="{{ route('admin.templates.status') }}" data-title="Seçiniz"></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('templates.destroy', $template->id) }}" class="btn btn-outline-danger btn-sm" title="Sil" onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $template->id }}').submit();"><span class="fa fa-trash"></span></a>
                                        <form id="delete-form-{{ $template->id }}" action="{{ route('templates.destroy', $template->id) }}" method="POST" style="display: none;">
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
    <script src="{{ asset('assets/plugins/x-editable/js/bootstrap-editable.min.js') }}"></script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.change_cat').on('change', function (e) {

                e.preventDefault();
                var $this = $('.change_cat');
                var dataId = $('.collapse').attr('data-id');

                if ($this.val() !== '') {
                    $.post("{!! route('templates.category') !!}", {catId: $this.val(), templateId: dataId}, function (data) {
                        if (data === 'ok') {
                            alertify.alert("Kategori Değiştirilmiştir.");

                            location.reload();
                        }
                    });
                }
            });

            $('.context').on('shown', function (e, editable) {
                $('.textarea_modal_widget .input-large').parents('form').removeClass('form-inline');
            });

            $.fn.editableform.buttons =
                '<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light" title="Kaydet"><i class="mdi mdi-check"></i></button>' +
                '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light" title="İptal"><i class="mdi mdi-close"></i></button>';

            // Parameters
            $('.context').editable({
                ajaxOptions: {
                    type: 'put',
                },
                showbuttons: 'bottom',
                mode: 'inline',
                rows: 20,
                emptytext: 'İçerik ekle',
                defaultValue: '',
                success: function(response) {
                    let result= JSON.parse(response);
                    alert(result.message);
                },
                params: function (params) {
                    params.type = 'context';
                    return params;
                }
            });

            $('.section').editable({
                ajaxOptions: {
                    type: 'put',
                },
                showbuttons: 'bottom',
                mode: 'inline',
                params: function (params) {
                    params.type = 'section';
                    return params;
                }
            });

            $('.status').editable({
                source: [
                    {value: 0, text: 'Deaktif'},
                    {value: 1, text: 'Aktif'}
                ],
                display: function (value, sourceData) {
                    let colors = {1: "green", 0: "red"},
                        checked = $.fn.editableutils.itemsByValue(value, sourceData);

                    if (checked.length) {
                        $(this).text(checked[0].text).css("color", colors[value]);
                    } else {
                       $(this).empty();
                    }
                },
                mode: 'inline',
                ajaxOptions: {
                    type: 'get',
                },
                showbuttons: false
            });

        });
    </script>
@endsection