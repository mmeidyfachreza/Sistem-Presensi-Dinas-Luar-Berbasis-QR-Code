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
        #header{
            text-align: center;
        }
        #content{
            padding-left: 10%;
            padding-right: 10%;
        }
        td{
            padding-bottom: 10px;
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
        <h3><u>SURAT PERINTAH TUGAS</u></h3>
    </div>
    <div id="content">
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{$assignmentOrder->employee->name}}</td>
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
            </tr>
        </table>
        @if ($assignmentOrder->teams()->exists())
        <p>bersama dengan karyawan berikut:</p>
        <table style="width: 100%; border-collapse: collapse;" id="teams">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignmentOrder->teams()->get() as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td style="text-align: center">{{$item->position->name ?? "Belum Diatur"}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <p>Demikianlah surat tugas ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.</p>
        <table id="signature">
            <tr>
                <td>Penyelia Unit</td>
                <td>Penyelia Umum</td>
            </tr>
            <tr>
                <td><img style="width: 25%" src="{{asset('storage/tanda_tangan/ttd 1.png')}}" alt=""></td>
                <td><img style="width: 25%" src="{{asset('storage/tanda_tangan/ttd 1.png')}}" alt=""></td>
            </tr>
            <tr>
                @foreach ($assignmentOrder->approvals()->get() as $item)
                <td>{{$item->name}}</td>
                @endforeach
            </tr>
        </table>
    </div>

<P></P>
</body>
</html>
