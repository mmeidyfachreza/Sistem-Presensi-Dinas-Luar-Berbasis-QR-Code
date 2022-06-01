@extends('layouts.app')
@section('plugin-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
    <x-content-header name="Karyawan"/>
    <section class="content">
        <div class="container-fluid">
             @if ($errors->any())
        <div class="alert alert-danger">
            <label for="">Error</label>
            <ul id="error">
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
                    <h3 class="card-title">Tambah Data Karyawan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("employee.store") }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="no_identity">No Identitas Karyawan</label>
                            <input type="text" class="form-control" name="no_identity" placeholder="Masukan Nomor Identitas Karyawan" value="{{old('no_identity')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukan Nama Lengkap" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukan Email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="division">Divisi</label>
                            <input type="text" class="form-control" name="division" placeholder="Masukan Divisi" value="{{old('division')}}">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">No Handphone</label>
                            <input type="text" class="form-control" name="phone_number" placeholder="Masukan No HP" value="{{old('phone_number')}}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukan Username" value="{{old('username')}}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Masukan Password" name="password">
                        </div>
                        <div class="form-group">
                            <label>Jenis Akun</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="role_id">
                                <option selected="selected" disabled>--pilih jenis akun--</option>
                                @foreach ($roles as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
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
                                <a href="{{route('employee.index')}}" class="dropdown-item">Kembali</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- Select2 -->
<script src="{{asset('template/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('template/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection
@section('js')
<script>
    $(function () {

    //Initialize Select2 Elements
    $('.select2').select2();
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    //Money Euro
    $('[data-mask]').inputmask()
    });
</script>
@endsection

