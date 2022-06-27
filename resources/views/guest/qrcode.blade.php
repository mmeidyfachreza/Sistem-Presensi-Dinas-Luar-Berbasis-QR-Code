@extends('layouts.app')
@section('plugin-css')

@endsection
@section('content')
<x-content-header name="QR Code Presensi {{$projectName}}" />
<section class="content">
    <div class="container-fluid">
        <div class="visible-print text-center">
            {!! QrCode::size(300)->errorCorrection($errorCorrectionLevel)->generate($codewords); !!}
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
@if (app()->environment(['local', 'staging','testing']))
<section class="content">
    <form action="{{ route("qrcode.show",$slugString) }}" method="GET">
        @csrf
        <table>
            <tr>
                <td><button type="submit" class="btn btn-primary" @disabled($errorCorrectionLevel=='H') name="errorCorrectionLevel" value="H">Level H</button></td>
                <td><button type="submit" class="btn btn-primary" @disabled($errorCorrectionLevel=='Q') name="errorCorrectionLevel" value="Q">Level Q</button></td>
                <td><button type="submit" class="btn btn-primary" @disabled($errorCorrectionLevel=='M') name="errorCorrectionLevel" value="M">Level M</button></td>
                <td><button type="submit" class="btn btn-primary" @disabled($errorCorrectionLevel=='L') name="errorCorrectionLevel" value="L">Level L</button></td>
            </tr>
        </table>

    </form>
</section>
@endif

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
