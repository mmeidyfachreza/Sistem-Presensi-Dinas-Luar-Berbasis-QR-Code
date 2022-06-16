@extends('layouts.app')
@section('plugin-css')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('template/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">

@endsection
@section('custom-css')
    <style>
        span.required{
         color: red;
        }
    </style>
@endsection
@section('content')
<x-content-header name="Tambah Kegiatan Kerja Lapangan" />
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
                    <h3 class="card-title">Tambah Data Kegiatan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("field_work_activity.store") }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="project_name">Nama Proyek <x-required-sign/></label>
                            <input type="text" class="form-control" name="project_name" placeholder="Masukan nama proyek" value="{{old('project_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Kegiatan</label>
                            <textarea class="form-control" name="description" rows="1" placeholder="Masukan deskripsi kegiatan">{{old('description')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="pic_name">Nama PIC <x-required-sign/></label>
                            <input type="text" class="form-control" name="pic_name" placeholder="Masukan nama PIC" value="{{old('pic_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="pic_position">Jabatan PIC <x-required-sign/></label>
                            <input type="text" class="form-control" name="pic_position" placeholder="Masukan jabatan PIC" value="{{old('pic_position')}}">
                        </div>
                        <div class="form-group">
                            <label for="pic_email">Email PIC <x-required-sign/></label>
                            <input type="email" class="form-control" name="pic_email" placeholder="Masukan Email PIC" value="{{old('pic_email')}}">
                        </div>
                        <div class="form-group">
                            <label for="pic_phone_number">Nomor HP PIC <x-required-sign/></label>
                            <input type="text" class="form-control" name="pic_phone_number" placeholder="Masukan Nomor HP PIC" value="{{old('pic_phone_number')}}">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat Kegiatan</label>
                            <textarea class="form-control" name="address" rows="1" placeholder="Masukan alamat kegiatan">{{old('address')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="geo_location">Geolokasi Kegiatan PIC <x-required-sign/></label>
                            <input type="text" class="form-control" name="geo_location" placeholder="Contoh: -7.771541, 110.361463" value="{{old('geo_location')}}">
                        </div>
                        <div class="form-group">
                            <label for="daterange">Jadwal Kegiatan <x-required-sign/></label>
                            <input type="text" class="form-control float-right" id="reservation" name="daterange">
                        </div>
                        <div class="form-group">
                            <label>Karyawan yang terlibat :</label>
                            <select class="duallistbox" multiple="multiple" name="team[]">
                                @forelse ($employees as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                    <option disabled>Tidak ada data</option>
                                @endforelse
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
<!-- InputMask -->
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('template/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>

@endsection
@section('js')
<script>
    $(document).ready(function () {
            //Date range picker
            $('#reservation').daterangepicker();
        });
    $(function () {
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    });
</script>
@endsection
