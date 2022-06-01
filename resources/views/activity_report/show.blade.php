@extends('layouts.app')
@section('plugin-css')
    <!-- dropzonejs -->
  <link rel="stylesheet" href="{{asset('template/plugins/dropzone/min/dropzone.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{asset('template/plugins/ekko-lightbox/ekko-lightbox.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection
@section('content')
    <x-content-header name="Laporan kegiatan"/>
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
                    <h3 class="card-title">Ubah Laporan Kegiatan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("activity_report.update",$activityReport->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="title">Judul</label>
                            <p>{{$activityReport->title}}</p>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Kegiatan</label>
                            <p>{{$activityReport->description}}</p>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kegiatan Dilaksanakan</label>
                            <p>{{$activityReport->date}}</p>
                        </div>
                        <div class="form-group">
                            <label for="document">Foto Kegiatan</label>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Daftar Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x=1?>
                                        @foreach ($activityReport->getMedia('images') as $key => $image)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>
                                                <a href="{{$image->getUrl('thumb')}}" data-toggle="lightbox" data-title="Foto {{$x++}}" data-gallery="gallery">
                                                    Lihat Foto
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <a href="{{route('activity_report.index')}}" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
@endsection
@section('plugin-js')
<!-- dropzonejs -->
<script src="{{asset('template/plugins/dropzone/min/dropzone.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('template/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('template/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Ekko Lightbox -->
<script src="{{asset('template/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
@endsection
@section('js')
<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
});

  </script>
@endsection
