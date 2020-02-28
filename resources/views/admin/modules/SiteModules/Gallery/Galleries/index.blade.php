@extends('admin/layouts.app')
@section('module_css')
    <link href="{{ asset('assets/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css">
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
                            @if(count($categories) < 1)
                            <div class="col-md-12">
                                <a href="{{ route('gallery.create') }}" class="btn btn-success btn-sm float-right m-b-20"><span class="fa fa-plus"></span> Yeni İçerik</a>
                                <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm float-right m-b-20 m-r-5"><span class="fa fa-chevron-left"></span> Geri</a>
                            </div>
                            @endif
                            <div class="clearfix"></div>
                                @if(count($categories) > 0)
                                    <div class="col-md-12">
                                        <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm float-right m-b-20 m-r-5"><span class="fa fa-chevron-left"></span> Geri</a>
                                    </div>
                                    <p>
                                        Lütfen fotoğraf eklemek istediğiniz galeriyi seçiniz.
                                    </p>
                                    @else
                                    <h2>
                                        {{ $categoryName[0]['name'] }} Galerisi
                                    </h2>
                                    <p>
                                        Bu galeriye yeni fotoğraf eklemek için lütfen yukarıdaki <strong>Yeni İçerik</strong> butonuna basınız.
                                    </p>
                                <div class="col-md-12">
                                    <div class="float-left">
                                        <button class="btn btn-sm btn-primary" id="gallery-toggle-items">Tümünü Seç</button>
                                    </div>
                                    <div class="float-right">
                                        <button class="btn btn-sm btn-danger deleteGallery" title="Seçilenleri Sil"><i class="fa fa-trash"></i> Sil</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                @if( count($gallery) > 0)
                                  <div class="row">
                                    <div class="gallery m-lg-3">
                                        @foreach($gallery as $item)
                                            <a href="{{ asset('uploads/gallery/'. $categoryName[0]['slug']) }}/{{ $item->name }}" class="gallery-item">
                                                <div class="image d-block mx-auto">
                                                    <img src="{{ asset('uploads/gallery/'. $categoryName[0]['slug']) }}/thumbnail/{{ $item->name }}"
                                                         width="210"
                                                         alt="{{ $item->name }}">
                                                    <ul class="gallery-item-controls">
                                                        <li title="Seç">
                                                            <label class="check">
                                                                <input type="checkbox" class="icheckbox" value="{{ $item->id  }}"
                                                                       data-path="{{ $categoryName[0]['slug'] }}/{{ $item->name }}"
                                                                       data-thumb="{{ $categoryName[0]['slug'] }}/thumbnail/{{ $item->name }}"/>
                                                            </label>
                                                        </li>
                                                        <li><span class="gallery-item-remove" id="{{ $item->id  }}"><i class="fa fa-times" title="Sil"></i></span></li>
                                                    </ul>
                                              </div>
                                            </a>
                                        @endforeach
                                    </div>
                                  </div>
                                 @endif
                                @endif
                                <div class="row">
                                    @foreach($categories as $category)
                                        <div class="col-md-2">
                                            <a href="{{ url('admin/gallery/list',$category->id) }}">
                                                <img class="img-thumbnail img-responsive" style="height: 175px;"
                                                     src="{{ asset('uploads/gallery/'. $category->slug) }}/{{ $category->photo }}">
                                            </a>
                                            <h6 class="text-center">{{ $category->name }}</h6>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('module_js')
    <script src="{{ asset('assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}"></script>
    <script>

        (function($) {

            'use strict';

            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('.gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: '#%curr% yükleniyor...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">#%curr%</a> yüklenememiştir.'
                }
            });

        }).apply(this, [jQuery]);

        $(".icheckbox").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});

        /* Gallery Items */
        $(".gallery-item .iCheck-helper").on("click",function(){
            var wr = $(this).parent("div");
            if(wr.hasClass("checked")){
                $(this).parents(".gallery-item").addClass("active");
            }else{
                $(this).parents(".gallery-item").removeClass("active");
            }
        });
        $(".gallery-item-remove").on("click",function(){
            $(this).parents(".gallery-item").fadeOut(400,function(){
                $(this).remove();
            });
            return false;
        });
        $("#gallery-toggle-items").on("click",function(){

            $(".gallery-item").each(function(){

                var wr = $(this).find(".iCheck-helper").parent("div");

                if(wr.hasClass("checked")){
                    $(this).removeClass("active");
                    wr.removeClass("checked");
                    wr.find("input").prop("checked",false);
                }else{
                    $(this).addClass("active");
                    wr.addClass("checked");
                    wr.find("input").prop("checked",true);
                }

            });

        });
        /* END Gallery Items */

        /* Gallery Delete*/
        $('.deleteGallery').on('click', function (e) {

            e.preventDefault();

            if ($('.icheckbox').is(':checked')) {

                var data = [];
                $(':checkbox:checked').each(function () {
                    data.push({
                        id: $(this).val(),
                        path : $(this).attr('data-path'),
                        thumb : $(this).attr('data-thumb')
                    });
                });

                // Delete
                $.ajax({
                    method: "POST",
                    url: '/admin/gallery/deletePhotos',
                    data: {deleteData: data},
                    success: function (data) {
                        if (data === 'redirect') {
                            location.reload();
                        }
                    }
                });

            } else {
                alertify.alert("Lütfen silinecek bir kayıt seçiniz.");
            }

        });

    </script>
@endsection