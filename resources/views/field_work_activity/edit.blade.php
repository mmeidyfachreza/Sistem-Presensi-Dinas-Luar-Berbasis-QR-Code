@extends('layouts.app')
@section('plugin-css')
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="{{asset('template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
@endsection
@section('content')
<x-content-header name="Project Perumahan {{$project->name}}"/>
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
                    <h3 class="card-title">Ubah Data Project</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("project.update",['residence'=>$residence->hash,'project'=>$project->hash]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama <x-required-sign/></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukan name project" value="{{$project->name}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Catatan</label>
                            <textarea class="form-control" name="note" id="note" rows="1" placeholder="Masukan catatan">{{$project->note}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Kontraktor yang terlibat :</label>
                            <select class="duallistbox" multiple="multiple" name="team[]">
                                @forelse ($contractors as $item)
                                    <option value="{{$item->id}}" @if (in_array($item->id,$teams)) selected  @endif >{{$item->name}}</option>
                                @empty
                                    <option disabled>Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Sekolah <x-required-sign/></label>
                            <select class="form-control select2bs4" style="width: 100%;" id="school" name="school_id" required>
                                @foreach ($schools as $item)
                                <option value="{{$item->id}}" @if ($project->school_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                         --}}

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
                                <a href="{{route('project.index',['residence'=>$residence->hash,'project'=>$project->hash])}}" class="dropdown-item">Kembali</a>
                            </div>
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
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
@endsection
@section('js')
<script>
    $('.save_confirms').click(function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");

        event.preventDefault();

        Swal.fire({
                title: 'Apakah anda yakin untuk menyimpan?',
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

    $(function () {
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    });
</script>
@endsection


