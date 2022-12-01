<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: 'Times New Roman', Times, serif;
        }
        table#data , table#data thead tr th , table#data tbody tr td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        #header{
            text-align: center;
        }
        /* #content{
            padding-left: 2%;
            padding-right: 2%;
        } */
        td{
            text-align: center;
        }
        ul.no-bullets {
        list-style-type: none; /* Remove bullets */
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margins */
        }
        #signature{
            width: 100%;
        }
        #signature tr td{
            text-align: center
        }
    </style>
</head>
<body>
    <div id="header">
        <h2 style="margin: 0%"><u>Rekap Presensi Karyawan CV Thortech Asia Software</u></h3>
        <h4 style="margin: 0%">Proyek : {{$project_name}}</h2>
    </div>
    <div id="content">
        @foreach ($presences as $month => $employees)
        <p><b>Bulan: {{$month}}</b></p>
        <table style="width: 100%" id="data">
            <thead>
                <tr>
                    <th>Nama</th>
                    @for ($i = 0; $i < $dayInMonth; $i++)
                        <th>{{$i+1}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $name => $day)
                <tr>
                    <td>{{$name}}</td>
                    @for ($i = 0; $i < $dayInMonth; $i++)
                    @if (isset($day[$i]))
                    <td style="background-color: #c2f0c2">{{$day[$i][0]['work_duration']}} Jam</td>
                    @else
                    <td>0 Jam</td>
                    @endif
                    @endfor
                </tr>
                @endforeach
            </tbody>
            {{-- <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{$presence->employee->name}}</td>
            </tr>
            <tr>
                <td>Unit</td>
                <td>:</td>
                <td>{{$assignmentOrder->employee->department->name}}</td>
            </tr>
            <tr>
                <td>Untuk melakukan tugas ke</td>
                <td>:</td>
                <td>{{$assignmentOrder->destination}}</td>
            </tr>
            <tr>
                <td>Dalam rangka</td>
                <td>:</td>
                <td>{{$assignmentOrder->purpose}}</td>
            </tr>
            <tr>
                <td>Dari Tanggal</td>
                <td>:</td>
                <td>{{$assignmentOrder->start_date}} -  {{$assignmentOrder->end_date}}</td>
            </tr> --}}
        </table>
        @endforeach
        <br>
        <table style="width: 100%" id="signature">
            <tr>
                <td style="width: 50%">&nbsp;</td>
                <td>Staff Administrasi <br><br><br><br> Fefi</td>
            </tr>
        </table>
    </div>

<P></P>
</body>
</html>
