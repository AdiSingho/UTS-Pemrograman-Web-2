<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tugas</title>
</head>
<body>
    <h1>Daftar Tugas UTS</h1>
    <ul>
        @foreach($daftarTugas as $tugas)
            <li>{{ $tugas->deskripsi }}</li>
        @endforeach
    </ul>
</body>
</html>