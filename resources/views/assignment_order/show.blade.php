@extends('layouts.app')
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
                                <th>Unit</th>
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
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Detail Data Pengajuan Perintah Tugas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("assignment_order.update",$assignmentOrder->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="destination" >Untuk melaksanakan tugas ke</label>
                            <p>{{$assignmentOrder->destination}}</p>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Deskripsi Kegiatan</label>
                            <p>{{$assignmentOrder->purpose}}</p>
                        </div>
                        <div class="form-group">
                            <label>Dari tanggal:</label>
                            <p>{{$assignmentOrder->daterange}}</p>
                        </div>
                        <div>
                            @if (Auth::user()->hasAnyRole(['penyelia unit','penyelia umum']))
                            <a href="{{route('assignment_order.index.approval')}}" class="btn btn-danger">Kembali</a>
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
