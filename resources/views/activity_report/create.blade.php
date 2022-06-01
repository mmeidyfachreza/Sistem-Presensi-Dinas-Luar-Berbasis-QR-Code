@extends('layouts.app')
@section('plugin-css')
    <!-- dropzonejs -->
  <link rel="stylesheet" href="{{asset('template/plugins/dropzone/min/dropzone.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
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
                    <h3 class="card-title">Buat Laporan Kegiatan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("activity_report.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Kegiatan</label>
                            <textarea id="description" rows="3" class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kegiatan Dilaksanakan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime"
                                    data-inputmask-inputformat="dd/mm/yyyy" name="date" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Documents</label>
                            <div class="needsclick dropzone" id="document-dropzone">

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
            <!-- /.card -->
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
@endsection
@section('js')
<script>
    $(function () {
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
        $('form').append('<input type="hidden" name="images[]]" value="' + response.name + '">')
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
        $('form').find('input[name="images[]]"][value="' + name + '"]').remove()
      },
      init: function () {
        @if(isset($project) && $project->image)
          var files =
            {!! json_encode($project->iamges) !!}
          for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="images[]]" value="' + file.file_name + '">')
          }
        @endif
      }
    }
  </script>
@endsection
