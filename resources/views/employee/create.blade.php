@extends('layouts.app')
@section('plugin-css')

@endsection
@section('content')
<x-content-header name="Presensi {{$fieldWorkActivity->project_name}}" />
<section class="content" id="app">
    <div class="container-fluid">
        <Presensi-Component project-id="{{ $fieldWorkActivity->id }}"><Presensi-Component/>
    </div>
</section>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p> <b>Catatan:</b> pastikan lokasi anda berada di sekitar titik <a href="https://maps.google.com/maps?z=12&t=m&q=loc:{{str_replace(', ','+',$fieldWorkActivity->geo_location)}}" target="_blank">{{$fieldWorkActivity->geo_location}}</a> sebelum melakukan presensi</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
