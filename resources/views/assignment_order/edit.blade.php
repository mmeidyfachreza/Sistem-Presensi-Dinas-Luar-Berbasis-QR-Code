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
        @if ($assignmentOrder->approvals()->count())
        <!-- TABLE: Persetujuan -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Status Persetujuan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                @if (in_array(Auth::user()->employee->position_id,[1,2]))
                                <th>Alasan</th>
                                @endif
                                {{-- <th>Tanggal</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignmentOrder->approvals()->get() as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->position->name}}</td>
                                @if ($item->id == Auth::user()->employee_id)
                                    @if ($item->pivot->approval)
                                    <td>{{$item->pivot->approval ?? "menunggu"}}</td>
                                    <td>{{$item->pivot->reason ?? ""}}</td>
                                    @elseif (!$item->pivot->approval)
                                    <form action="{{ route("assignment_order.update.approval",$assignmentOrder->id) }}" method="post" id="approval_form">
                                        @method('PUT')
                                        @csrf
                                        <td>
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                  Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="submit" class="dropdown-item" value="disetujui" name="approval">Disetujui</button>
                                                    <button type="submit" class="dropdown-item" value="ditolak" name="approval">Ditolak</button>
                                                    {{-- <button type="submit" class="dropdown-item" value="direvisi" name="approval">Direvisi</button> --}}
                                                </div>
                                              </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <textarea id="description" rows="2" class="form-control" name="reason">{{$item->pivot->reason}}</textarea>
                                            </div>
                                        </td>
                                    </form>
                                    @endif
                                @elseif (in_array(Auth::user()->employee->position_id,[1,2]))
                                    <td>{{$item->pivot->approval ?? "menunggu"}}</td>
                                    <td>{{$item->pivot->reason ?? ""}}</td>
                                @else
                                <td>{{$item->pivot->approval ?? "menunggu"}}</td>
                                @endif
                                {{-- <td>{{$item->updated_at}}</td> --}}
                            </tr>
                            @empty

                            @endforelse
                            {{-- <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

        </div>
        <!-- /.card -->
        @endif
        @if ($assignmentOrder->status!='draft')
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Rekan Kegiatan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignmentOrder->teams()->get() as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->position->name ?? "Belum Diatur"}}</td>
                            </tr>
                            @empty

                            @endforelse
                            {{-- <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

        </div>
        <!-- /.card -->
        @endif
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Ubah Data Pengajuan Perintah Tugas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("assignment_order.update",$assignmentOrder->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="destination" >Untuk melaksanakan tugas ke</label>
                            <input type="text" class="form-control" name="destination" value="{{$assignmentOrder->destination}}" @if ($assignmentOrder->status!='draft') disabled @endif>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Deskripsi Kegiatan</label>
                            <textarea id="purpose" rows="3" class="form-control" name="purpose" @if ($assignmentOrder->status!='draft') disabled @endif>{{$assignmentOrder->purpose}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Dari tanggal:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="reservation" value="{{$assignmentOrder->daterange}}" @if ($assignmentOrder->status!='draft') disabled @endif >
                            </div>
                            <!-- /.input group -->
                        </div>
                        @if ($assignmentOrder->status=='draft')
                        <div class="form-group">
                            <label>rekan tugas (jika ada) :</label>
                            <select class="duallistbox" multiple="multiple" name="team[]">
                                @forelse ($employees as $item)
                                    <option value="{{$item->id}}" @if (in_array($item->id,$teams)) selected  @endif >{{$item->name}}</option>
                                @empty
                                    <option disabled>Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        @endif
                        <div>
                            @if ($assignmentOrder->status=='draft')
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Simpan dan Tutup</button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                <button type="submit" class="dropdown-item" name="sending" value="true">Simpan dan Ajukan</button>
                                <button type="submit" class="dropdown-item">Simpan</button>
                                <div class="dropdown-divider"></div>
                                <a href="{{route('assignment_order.index')}}" class="dropdown-item">Kembali</a>
                                </div>
                            </div>
                            @else
                            <a href="{{route('assignment_order.index')}}" class="btn btn-danger">Kembali</a>
                            @endif

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
})
</script>
@endsection
