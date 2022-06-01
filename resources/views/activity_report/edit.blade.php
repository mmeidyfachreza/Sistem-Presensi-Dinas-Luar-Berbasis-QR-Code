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
                            <input type="text" class="form-control" name="title"
                                value="{{old("title",$activityReport->title)}}">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Kegiatan</label>
                            <textarea id="description" rows="3" class="form-control" name="description">{{old("description",$activityReport->description)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kegiatan Dilaksanakan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="dd/mm/yyyy" name="date" data-mask
                                    value="{{old("date",$activityReport->date)}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Tambah Foto Kegiatan</label>
                            <div class="needsclick dropzone" id="document-dropzone">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Foto Kegiatan</label>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Daftar Foto</th>
                                            <th>Hapus</th>
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
                                            <td>
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" name="selectedImage[]" value="{{$image->id}}" id="checkboxDanger{{$key}}">
                                                    <label for="checkboxDanger{{$key}}">
                                                    </label>
                                                  </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                                <a href="{{route('activity_report.index')}}" class="dropdown-item">Kembali</a>
                            </div>
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

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
    });
    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
      url: '{{ route('activity_report.storeMedia') }}',
      maxFilesize: 2, // MB
      addRemoveLinks: true,
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      success: function (file, response) {
        $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
        uploadedDocumentMap[file.name] = response.name
      },
      removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
          name = file.file_name
        } else {
          name = uploadedDocumentMap[file.name]
        }
        $('form').find('input[name="images[]"][value="' + name + '"]').remove()
      },
      init: function () {
        @if(isset($project) && $project->document)
          var files =
            {!! json_encode($project->document) !!}
          for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
          }
        @endif
      }
    }
  </script>
@endsection
