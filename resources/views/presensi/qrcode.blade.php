@extends('layouts.app')
@section('plugin-css')

@endsection
@section('content')
<x-content-header name="Beranda" />
<section class="content">
    <div class="container-fluid">
        <div class="visible-print text-center">
            {!! QrCode::size(100)->generate(Request::url()); !!}
            <p>Scan me to return to the original page.</p>
        </div>
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
