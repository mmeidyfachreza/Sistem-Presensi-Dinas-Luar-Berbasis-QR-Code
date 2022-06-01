@extends('layouts.app')
@section('plugin-css')
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
<x-content-header name="Detail Kegiatan Kerja Lapangan" />
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
                        <h3 class="card-title" style="margin-top: 0.3rem">Proyek {{$fieldWorkActivity->project_name}}</h3>
                    </div>

                    <div class="col">
                        <div class="card-tools float-right">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    {{-- <button class="btn btn-default" data-toggle="modal" data-target="#modal-sm">
                                        <i class="fas fa-filter"></i>
                                    </button> --}}
                                    @if (isset($filter))
                                    <a href="{{route('field_work_activity.index')}}" class="btn btn-danger btn-sm"><i
                                            class="fas fa-undo"></i></a>
                                    @endif
                                    @if (!isset($trashed))
                                    <a href="{{route('field_work_activity.edit',$fieldWorkActivity->id)}}" class="btn btn-warning btn-sm">Edit Data</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label>Deskripsi Kegiatan</label>
                    <p>{{$fieldWorkActivity->description}}</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <p>{{$fieldWorkActivity->address}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Tanggal Kegiatan</label>
                            <p>{{$fieldWorkActivity->start_date->format('j F Y')}} - {{$fieldWorkActivity->end_date->format('j F Y')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Link Presensi</label>
                            <p>{{$fieldWorkActivity->link}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Lokasi Presensi</label>
                            <p><a href="https://maps.google.com/maps?z=12&t=m&q=loc:{{str_replace(', ','+',$fieldWorkActivity->geo_location)}}" target="_blank">{{$fieldWorkActivity->geo_location}}</a></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama PIC</label>
                            <p>{{$fieldWorkActivity->pic_name}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Jabatan</label>
                            <p>{{$fieldWorkActivity->pic_position}}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kontak</label>
                    <p>HP : {{$fieldWorkActivity->pic_phone_number ?? '-'}} / Email : {{$fieldWorkActivity->pic_email ?? '-'}}</p>
                </div>
            </div>
            <div class="card-footer">

            </div>
            <!-- /.card-body -->
        </div>
        {{-- list employee --}}
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title" style="margin-top: 0.3rem">Daftar karyawan yang terlibat</h3>
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
                            <th>Kontak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $key => $employee)
                        <tr>
                            <td>{{$employees->firstItem() + $key}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->phone_number}}</td>
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
