<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nilai Semester</title>
    <style>
        /* Styling */
        * {
            font-family: Arial, Helvetica, sans-serif
        }

        .text-center {
            text-align: center;
        }

        .table {
            border-collapse: collapse;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #353535;
            font-size: 13px;
        }

        .text-left {
            text-align: left;
        }

    </style>
</head>

<body>
    <h3 class="text-center">Nilai Semester Kelas
        {{ $course->classGroup->degree->degree . ' ' . $course->classGroup->name }}</h3>
    <h4 class="text-center">Tahun Ajaran {{ $studyYear->year . '/' . ($studyYear->year + 1) }}
        {{ $semester == '1' ? 'Ganjil' : 'Genap' }}</h4>
    <table class="table" width="100%" cellpadding="8">
        <tr>
            <th width="1%">No.</th>
            <th width="20%">NIS/NISN</th>
            <th>Nama Siswa</th>
            <th width="10%">Nilai</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->student->identity_number }}</td>
                <td>{{ $item->student->name }}</td>
                <td>{{ $item->score }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
