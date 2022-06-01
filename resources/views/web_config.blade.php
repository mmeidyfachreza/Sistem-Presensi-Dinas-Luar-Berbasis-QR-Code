@extends('layouts.app')
@section('plugin-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
    <x-content-header name="Pengaturan"/>
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Website</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("configuration.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Aplikasi</label>
                            <input type="text" class="form-control" name="web_name" value="{{$configuration->web_name ?? ''}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Wallpaper Login</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file-ip-1" accept="image/*" onchange="showWallpaperPreview(event);" name="login_wallpaper">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="overflow: hidden">
                            <label for="wallpaper-login-preview">Pratinjau Wallpapaer Login</label>
                            <div>
                                <img id="wallpaper-login-preview" style="max-width: 20%;margin-left: auto;margin-right: auto;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Logo Website</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file-ip-1" accept="image/*" onchange="showLogoPreview(event);" name="logo">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="overflow: hidden">
                            <label for="logo-preview">Pratinjau Logo Website</label>
                            <div>
                                <img id="logo-preview" style="max-width: 20%;margin-left: auto;margin-right: auto;"/>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="exit" value="true">Simpan dan
                                Tutup</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <button type="submit" class="dropdown-item">Simpan</button>
                                <div class="dropdown-divider"></div>
                                <a href="{{route('department.index')}}" class="dropdown-item">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

    </section>
<!-- Main content -->
@endsection
@section('plugin-js')
<!-- Select2 -->
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@endsection
@section('js')
<script>
    function showWallpaperPreview(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("wallpaper-login-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }

    function showLogoPreview(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("logo-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }

    $(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection
