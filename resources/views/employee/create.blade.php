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
