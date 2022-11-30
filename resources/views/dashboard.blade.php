@extends('layouts.app')
@section('plugin-css')

@endsection
@section('content')
<x-content-header name="Beranda" />
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            {{-- @can('assignment order index')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$collection['totalAssignment']}}</h3>

                        <p>Pengajuan Perintah Tugas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document-text"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan
            @can('employee index')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$collection['totalEmployee']}}</h3>

                        <p>Karyawan terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan --}}
            <!-- ./col -->
            @can('index employee')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$data['totalEmployee']}}</h3>

                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{route('employee.index')}}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan
            <!-- ./col -->
            @can('index employee')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$data['totalActivity']}}</h3>

                        <p>Kegiatan Dinas Luar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <a href="{{route('field_work_activity.index')}}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection
@section('plugin-js')
<!-- ChartJS -->
<script src="{{asset("template/plugins/chart.js/Chart.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset("template/plugins/sparklines/sparkline.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset("template/plugins/jquery-knob/jquery.knob.min.js")}}"></script>
@endsection
@section('js')

@endsection
