@extends('layouts.app')
@section('plugin-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
<x-content-header name="Presensi Karyawan"/>
<section class="content">
    <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger">
            <label for="">Error</label>
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
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title" style="margin-top: 0.3rem">Daftar Presensi Karyawan @isset($trashed) nonaktif | <a
                                href="{{route('presence.index')}}">kembali</i></a> @endisset</h3>
                    </div>
                    <div class="col">
                        <div class="card-tools float-right">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal-sm">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    @if (isset($filter))
                                    <a href="{{route('presence.index')}}" class="btn btn-danger btn-sm"><i
                                            class="fas fa-undo"></i></a>
                                    @endif
                                    @if (!isset($trashed))
                                    <a href="{{route('presence.print')}}" class="btn btn-success btn-sm">Cetak Laporan</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jam Hadir</th>
                            <th>Jam Pulang</th>
                            <th>Tanggal</th>
                            <th>Proyek</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presences as $key => $presence)
                        <tr>
                            <td>{{$presences->firstItem() + $key}}</td>
                            <td>{{$presence->employee->name}}</td>
                            <td>{{$presence->start_time}}</td>
                            <td>{{$presence->end_time}}</td>
                            <td>{{$presence->date}}</td></td>
                            <td>{{$presence->field_work_activity->project_name}}</td></td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <a class="btn btn-info" href="{{route('presence.show'[$presence->hash])}}"><i
                                        class="fa fa-eye"></i></a> --}}
                                    @isset($trashed)
                                    <form class="btn-group delete-form" role="group"
                                        action="{{route('presence.restore',[$presence->hash])}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <button class="btn btn-info restore-confirms" value="{{$presence->name}}"
                                            type="submit" data-toggle="tooltip" title="Hapus Data"><i
                                                class="fa fa-trash-restore"></i></button>
                                    </form>
                                    @else
                                    <a class="btn btn-info" href="{{route('presence.show',$presence->id)}}"
                                        data-toggle="tooltip" title="List Kontraktor"><i class="fa fa-list"></i></a>
                                    <form class="btn-group delete-form" role="group"
                                        action="{{route('presence.destroy',$presence)}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-confirms" value="{{$presence->name}}"
                                            type="submit" data-toggle="tooltip" title="Hapus Data"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                    @endisset

                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                @isset($search)
                                Data Tidak Ditemukan
                                @else
                                Tidak Ada Data
                                @endisset
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="modal fade" id="modal-sm">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Filter Data</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('presence.filter')}}" method="get">
                                <div class="modal-body">
                                    @isset($trashed)
                                    <input type="hidden" name="trashed" value="true">
                                    @endisset
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="value" class="form-control float-right"
                                        placeholder="Masukan nama perumahan" value="{{$filter['value'] ?? ''}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Urutkan Data</label>
                                        <select class="form-control" name="sortBy" id="sortBy">
                                            <option @selected(isset($filter)&&$filter['sortBy']=="asc") value="asc">A ke Z</option>
                                            <option @selected(isset($filter)&&$filter['sortBy']=="desc") value="desc">Z ke A</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    {{$presences->setPath(url()->current())->links('pagination::bootstrap-4')}}
                </div>
                {{-- <div class="float-left">
                    @if (!isset($trashed))
                    <a href="{{route('presence.index.trashed')}}" class="btn btn-info">Tampilkan Project Nonaktif</a>
                    @endif
                </div> --}}
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
@endsection
@section('plugin-js')
<script src="{{asset('template/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection
@section('js')
    <script>
        $('.delete-confirms').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).val();
            event.preventDefault();
            Swal.fire({
                    title: 'Apakah anda yakin untuk menghapus project '+name+'?',
                    //text: "If you delete this, it will be gone forever.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak',
                    }).then((result) => {
                    /* Read more about isConfirmed, isDeni  ed below */
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
        });
        $('.restore-confirms').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).val();
            event.preventDefault();
            Swal.fire({
                    title: 'Apakah anda yakin untuk mengembalikan data '+name+'?',
                    //text: "If you delete this, it will be gone forever.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak',
                    }).then((result) => {
                    /* Read more about isConfirmed, isDeni  ed below */
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
        });

    </script>
@endsection
