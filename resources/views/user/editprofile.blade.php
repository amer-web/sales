@extends('layouts.master')
@section('title','تعديل الملف الشخصي')
@section('css')
    <!-- Croppie css -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/plugins/croppie/croppie.min.css')}}">

    <style type="text/css">
        .nounderline, .violet{
            color: #7c4dff !important;
        }
        .btn-dark {
            background-color: #7c4dff !important;
            border-color: #7c4dff !important;
        }
        .btn-dark .file-upload {
            width: 100%;
            padding: 10px 0px;
            position: absolute;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }
        .profile-img img{
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > تعديل الملف الشخصي</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">تعديل البيانات الشخصية</div>
                    <form class="form-horizontal" action="{{route('updateProfile.user')}}" method="POST">
                        @csrf
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">الاسم الأول</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="الاسم الأول"
                                           value="{{ old('firstname',auth()->user()->firstname) }}" name="firstname">
                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">اسم العائلة</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="اسم العائلة" name="lastname" value="{{ old('lastname',auth()->user()->lastname) }}">
                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">البريد الإلكترونى</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email',auth()->user()->email) }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">تحديث
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div  class="container">
                <div class="d-flex justify-content-center p-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">صورة الملف الشخصي</h5>
                            <div class="profile-img p-3">
                                <img src="{{auth()->user()->userImage()}}" id="profile-pic">
                            </div>
                            <div class="btn btn-dark">
                                <input type="file" class="file-upload" id="file-upload"
                                       name="profile_picture" accept="image/*">
                                تحديث الصورة
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Crop Image And Upload</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div id="resizer"></div>
                                <button class="btn rotate float-lef" data-deg="90" >
                                    <i class="fas fa-undo"></i></button>
                                <button class="btn rotate float-right" data-deg="-90" >
                                    <i class="fas fa-redo"></i></button>
                                <hr>
                                <button class="btn btn-block btn-dark" id="upload" >
                                    Crop And Upload</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{asset('assets/plugins/croppie/croppie.min.js')}}"></script>
    <script>
        $(function() {
            var croppie = null;
            var el = document.getElementById('resizer');

            $.base64ImageToBlob = function(str) {
                // extract content type and base64 payload from original string
                var pos = str.indexOf(';base64,');
                var type = str.substring(5, pos);
                var b64 = str.substr(pos + 8);

                // decode base64
                var imageContent = atob(b64);

                // create an ArrayBuffer and a view (as unsigned 8-bit)
                var buffer = new ArrayBuffer(imageContent.length);
                var view = new Uint8Array(buffer);

                // fill the view, using the decoded base64
                for (var n = 0; n < imageContent.length; n++) {
                    view[n] = imageContent.charCodeAt(n);
                }

                // convert ArrayBuffer to Blob
                var blob = new Blob([buffer], { type: type });

                return blob;
            }

            $.getImage = function(input, croppie) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        croppie.bind({
                            url: e.target.result,
                        });
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#file-upload").on("change", function(event) {
                $("#myModal").modal();
                // Initailize croppie instance and assign it to global variable
                croppie = new Croppie(el, {
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'circle'
                    },
                    boundary: {
                        width: 250,
                        height: 250
                    },
                    enableOrientation: true
                });
                $.getImage(event.target, croppie);
            });

            $("#upload").on("click", function() {
                croppie.result('base64').then(function(base64) {
                    $("#myModal").modal("hide");
                    $("#profile-pic").attr("src","{{asset('assets/plugins/croppie/ajax-loader.gif')}}");

                    var url = "{{ url('/demos/jquery-image-upload') }}";
                    var formData = new FormData();
                    formData.append("profile_picture", $.base64ImageToBlob(base64));

                    // This step is only needed if you are using Laravel
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data == "uploaded") {

                                $("#profile-pic").attr("src", base64);
                            } else {
                                $("#profile-pic").attr("src","/images/icon-cam.png");
                                console.log(data['profile_picture']);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $("#profile-pic").attr("src","/images/icon-cam.png");
                        }
                    });
                });
            });

            // To Rotate Image Left or Right
            $(".rotate").on("click", function() {
                croppie.rotate(parseInt($(this).data('deg')));
            });

            $('#myModal').on('hidden.bs.modal', function (e) {
                // This function will call immediately after model close
                // To ensure that old croppie instance is destroyed on every model close
                setTimeout(function() { croppie.destroy(); }, 100);
            })

        });

    </script>
@endsection
