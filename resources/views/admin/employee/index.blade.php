@extends('layouts.app')
@section('plugin-css')
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
<x-content-header name="Karyawan" />
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
                        <h3 class="card-title" style="margin-top: 0.3rem">Daftar Karyawan @isset($trashed) nonaktif | <a
                                href="{{route('employee.index')}}">kembali</i></a> @endisset</h3>
                    </div>
                    <div class="col">
                        <form action="{{route('employee.search')}}" method="post">
                            @csrf
                            <div class="card-tools float-right">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="value" class="form-control float-right"
                                        placeholder="Cari..." value="{{$search ?? ''}}">
                                    @isset($trashed)
                                    <input type="hidden" name="trashed" value="true">
                                    @endisset
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset($search))
                                        <a href="{{route('employee.index')}}" class="btn btn-danger btn-sm"><i
                                                class="fas fa-undo"></i></a>
                                        @endif
                                        @if (!isset($trashed))
                                        <a href="{{route('employee.create')}}" class="btn btn-success btn-sm">Tambah</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
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
                            <th>Divisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $key => $employee)
                        <tr>
                            <td>{{$employees->firstItem() + $key}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->division ?? "Belum Diatur"}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <a class="btn btn-info" href="{{route('employee.show',$employee->id)}}"><i
                                        class="fa fa-eye"></i></a> --}}
                                    @isset($trashed)
                                    <form class="btn-group delete-form" role="group"
                                        action="{{route('employee.restore',$employee->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <button class="btn btn-info restore-confirms" value="{{$employee->name}}"
                                            type="submit" data-toggle="tooltip" title="Hapus Data"><i
                                                class="fa fa-trash-restore"></i></button>
                                    </form>
                                    @else
                                    <a class="btn btn-warning" href="{{route('employee.edit',$employee->id)}}"
                                        data-toggle="tooltip" title="Ubah Data"><i class="fa fa-pen"></i></a>
                                    <form class="btn-group delete-form" role="group"
                                        action="{{route('employee.destroy',$employee->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-confirms" value="{{$employee->name}}"
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
            </div>
            <div class="card-footer">
                <div class="float-right">
                    {{$employees->setPath(url()->current())->links('pagination::bootstrap-4')}}
                </div>
                <div class="float-left">
                    @if (!isset($trashed))
                    <a href="{{route('employee.index.all')}}" class="btn btn-info">Tampilkan Karyawan Nonaktif</a>
                    @endif
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
@endsection
@section('plugin-js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- SweetAlert2 -->
<script src="{{asset('template/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection
@section('js')
    <script>
        $('.delete-confirms').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).val();
            event.preventDefault();
            Swal.fire({
                    title: 'Apakah anda yakin untuk menonaktifkan karyawan '+name+'?',
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
                    title: 'Apakah anda yakin untuk mengaktifkan kembali karyawan '+name+'?',
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
