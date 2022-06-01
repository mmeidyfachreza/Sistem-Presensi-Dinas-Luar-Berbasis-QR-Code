@extends('layouts.app')
@section('plugin-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
    <x-content-header name="Departemen"/>
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
                    <h3 class="card-title">Tambah Data Departemen</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("department.store") }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Departemen</label>
                            <input type="text" class="form-control" name="name" value="{{old('name','')}}">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <input type="text" class="form-control" name="description" value="{{old('description','')}}">
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
@endsection
@section('js')
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    });
</script>
@endsection
