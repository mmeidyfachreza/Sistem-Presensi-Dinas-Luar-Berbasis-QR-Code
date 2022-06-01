@extends('layouts.app')
@section('plugin-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
<x-content-header name="Laporan Kegiatan Keamanan" />
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
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title" style="margin-top: 0.3rem">Daftar Laporan Kegiatan Keamanan</h3>
                    </div>
                    <div class="col">
                        <form action="{{route('activity_report.search')}}" method="post">
                            @csrf
                            <div class="card-tools float-right">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="value" class="form-control float-right"
                                        placeholder="Cari..." value="{{$search ?? ''}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (isset($search))
                                        <a href="{{route('activity_report.index')}}" class="btn btn-danger btn-sm"><i class="fas fa-undo"></i></a>
                                        @endif
                                        <a href="{{route('activity_report.create')}}" class="btn btn-success btn-sm">Tambah</a>
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
                            <th>Judul Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activityReports as $key => $activityReport)
                        <tr>
                            <td>{{$activityReports->firstItem() + $key}}</td>
                            <td>{{$activityReport->title}}</td>
                            <td>{{$activityReport->date}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-info" href="{{route('activity_report.show',$activityReport->id)}}"><i
                                            class="fa fa-eye"></i></a>
                                    <a class="btn btn-warning" href="{{route('activity_report.edit',$activityReport->id)}}" data-toggle="tooltip" title="Ubah Data"><i
                                            class="fa fa-pen"></i></a>
                                    <form class="btn-group delete-form" role="group" action="{{route('activity_report.destroy',$activityReport->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-confirms" value="{{$activityReport->name}}" type="submit" data-toggle="tooltip" title="Hapus Data"><i
                                            class="fa fa-trash"></i></button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
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
                    {{$activityReports->setPath(url()->current())->links('pagination::bootstrap-4')}}
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
                    title: 'Apakah anda yakin untuk menghapus?',
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
