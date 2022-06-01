@extends('layouts.app')
@section('plugin-css')
    <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('template/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('template/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
@endsection
@section('content')
    <x-content-header name="Pengajuan Perintah Tugas"/>
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
                    <h3 class="card-title">Tambah Data Pengajuan Perintah Tugas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("assignment_order.store") }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="destination">Untuk melaksanakan tugas ke</label>
                            <input type="text" class="form-control" name="destination" value="{{old('destination','')}}">
                        </div>
                        <div class="form-group">
                            <label for="purpose">Deskripsi Kegiatan</label>
                            <textarea id="purpose" rows="3" class="form-control" name="purpose">{{old('purpose','')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Dari tanggal:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="reservation">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>rekan tugas (jika ada) :</label>
                            <select class="duallistbox" multiple="multiple" name="team[]">
                                @forelse ($employees as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                    <option disabled>Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        <!-- /.form group -->
                        {{-- <div class="form-group">
                            <label for="no_identity">No Identitas</label>
                            <input type="text" class="form-control" name="no_identity" value="{{old('no_identity','')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" value="{{old('name','')}}">
                        </div>
                        <div class="form-group">
                            <label for="born_place">Tempat Lahir</label>
                            <input type="text" class="form-control" name="born_place" value="{{old('born_place','')}}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="dd/mm/yyyy" name="born_date" value="{{old('born_date','')}}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea id="address" rows="3" class="form-control" name="address">{{old('address','')}}</textarea>
                        </div>
                        <div class="form-group clearfix">
                            <label for="">Jenis Kelamin</label>
                            @foreach ($gender as $item)
                            <div class="icheck-primary">
                                <input type="radio" name="gender" value="{{$item}}" id="{{$item}}">
                                <label for="{{$item}}">
                                    {{$item}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label>Departemen</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="department_id">
                                <option selected="selected" disabled>--pilih departemen--</option>
                                @foreach ($departments as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="{{old('username','')}}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Jenis Akun</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="role_id">
                                <option selected="selected" disabled>--pilih jenis akun--</option>
                                @foreach ($roles as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div>
                            <button type="submit" class="btn btn-primary" name="exit" value="true">Simpan dan Tutup</button>
                            <button type="submit" class="btn btn-success" name="sending" value="true">Simpan dan Ajukan</button>
                            <button type="submit" class="btn btn-default">Simpan</button>
                            <a href="{{route('assignment_order.index')}}" class="btn">Kembali</a>
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
<!-- InputMask -->
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('template/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
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
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    //Money Euro
    $('[data-mask]').inputmask()
    //Date range picker
    $('#reservation').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    })
    });
</script>
@endsection
