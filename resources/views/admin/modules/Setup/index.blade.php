@extends('admin/layouts.app')
@section('module_css')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Site Ayarları</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                            <li class="breadcrumb-item active">Site Ayarları</li>
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

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                        <span class="d-none d-md-block">Site Ayarları</span><span
                                                class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#contact" role="tab">
                                        <span class="d-none d-md-block">İletişim Bilgileri</span><span
                                                class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#analytics" role="tab">
                                        <span class="d-none d-md-block">Analiz Verileri</span><span
                                                class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#email" role="tab">
                                        <span class="d-none d-md-block">Email Ayarları</span><span
                                                class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span>
                                    </a>
                                </li>
                            </ul>
                            <form action="{{ route('admin.setup.update') }}" method="post">
                                {{ csrf_field() }}
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="home" role="tabpanel">
                                        <p class="sub-title">
                                            Burada site genel ayarlarını yapabilirsiniz. Site Kayıt Kodu'nu şifre
                                            sıfırlama isteği durumunda kullanabilirsiniz.
                                        </p>
                                        @foreach($setups as $setup)
                                            @if ($setup->config_section == 's' && $setup->config_name !='site_close')
                                                <div class="form-group">
                                                    <label for="{{ $setup->config_name }}"
                                                           class="col-md-3 control-label">{{ $setup->config_label }}</label>
                                                    <div class="col-md-6">
                                                        <input type="{{ $setup->config_input_type }}"
                                                               name="{{ $setup->config_name }}"
                                                               id="{{ $setup->config_name }}"
                                                               class="form-control"
                                                               value="{{ $setup->config_value }}"
                                                               placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}"
                                                                {{ $setup->config_name == 'site_reg_code' ? 'disabled="disabled"' : '' }} />
                                                        @if ($setup->config_help_text) <small class="form-text text-muted">{{ $setup->config_help_text }}</small> @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane p-3" id="contact" role="tabpanel">
                                        <p class="sub-title">
                                            Site iletişim bilgilerini buradan güncelleyebilirsiniz.
                                        </p>
                                        @foreach($setups as $setup)
                                            @if ($setup->config_section == 'c')
                                                <div class="form-group">
                                                    <label for="{{ $setup->config_name }}"
                                                           class="col-md-3 control-label">{{ $setup->config_label }}</label>
                                                    <div class="col-md-6">
                                                        @if ($setup->config_input_type == 'textarea')
                                                            <textarea
                                                                    name="{{ $setup->config_name }}"
                                                                    id="{{ $setup->config_name }}"
                                                                    class="form-control"
                                                                    rows="5"
                                                                    placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}">{{ $setup->config_value }}</textarea>
                                                            @else
                                                            <input type="{{ $setup->config_input_type }}"
                                                                   name="{{ $setup->config_name }}"
                                                                   id="{{ $setup->config_name }}"
                                                                   class="form-control"
                                                                   value="{{ $setup->config_value }}"
                                                                   placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}"/>
                                                        @endif
                                                            @if ($setup->config_help_text) <small class="form-text text-muted">{{ $setup->config_help_text }}</small> @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane p-3" id="analytics" role="tabpanel">
                                        <p class="sub-title">
                                            Site analiz bilgilerini buradan güncelleyebilirsiniz.
                                        </p>
                                        @foreach($setups as $setup)
                                            @if ($setup->config_section == 'a')
                                                <div class="form-group">
                                                    <label for="{{ $setup->config_name }}"
                                                           class="col-md-3 control-label">{{ $setup->config_label }}</label>
                                                    <div class="col-md-6">
                                                        @if ($setup->config_input_type == 'textarea')
                                                            <textarea
                                                                    name="{{ $setup->config_name }}"
                                                                    id="{{ $setup->config_name }}"
                                                                    class="form-control"
                                                                    rows="5"
                                                                    placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}">{{ $setup->config_value }}</textarea>
                                                        @else
                                                            <input type="{{ $setup->config_input_type }}"
                                                                   name="{{ $setup->config_name }}"
                                                                   id="{{ $setup->config_name }}"
                                                                   class="form-control"
                                                                   value="{{ $setup->config_value }}"
                                                                   placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}"/>
                                                        @endif
                                                            @if ($setup->config_help_text) <small class="form-text text-muted">{{ $setup->config_help_text }}</small> @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane p-3" id="email" role="tabpanel">
                                        <p class="sub-title">
                                            Site E-mail gönderim ayarlarını buradan güncelleyebilirsiniz.
                                        </p>
                                        @foreach($setups as $setup)
                                            @if ($setup->config_section == 'm')
                                                <div class="form-group">
                                                    <label for="{{ $setup->config_name }}"
                                                           class="col-md-3 control-label">{{ $setup->config_label }}</label>
                                                    <div class="col-md-6">
                                                        @if ($setup->config_input_type == 'textarea')
                                                            <textarea
                                                                    name="{{ $setup->config_name }}"
                                                                    id="{{ $setup->config_name }}"
                                                                    class="form-control"
                                                                    rows="5"
                                                                    placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}">{{ $setup->config_value }}</textarea>
                                                        @else
                                                            <input type="{{ $setup->config_input_type }}"
                                                                   name="{{ $setup->config_name }}"
                                                                   id="{{ $setup->config_name }}"
                                                                   class="form-control"
                                                                   value="{{ $setup->config_value }}"
                                                                   placeholder="{{ $setup->config_help_text == '' ? $setup->config_label : $setup->config_help_text }}"/>
                                                            @if ($setup->config_help_text) <small class="form-text text-muted">{{ $setup->config_help_text }}</small> @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary waves-effect waves-light float-right">
                                    <span class="fa fa-save"></span> Ayarları Kaydet
                                </button>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
@endsection