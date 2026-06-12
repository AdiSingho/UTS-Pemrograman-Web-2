<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tugas UTS</title>
</head>
<body>
    <h1>Daftar Tugas UTS</h1>

    <form action="/tugas" method="POST">
        @csrf
        <input type="text" name="deskripsi" placeholder="Nama tugas" required>
        <input type="date" name="tanggal_target" required>
        <button type="submit">Tambah</button>
    </form>

    <hr>

    <ul>
        @foreach($daftarTugas as $tugas)
            <li>
                {{ $tugas->deskripsi }} - {{ $tugas->tanggal_target }} 
                ({{ $tugas->is_selesai ? 'Selesai' : 'Belum' }})
                
                @if(!$tugas->is_selesai)
                    <form action="/tugas/{{ $tugas->id }}/selesai" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <button type="submit">Selesai</button>
                    </form>

                    <form action="/tugas/{{ $tugas->id }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <input type="text" name="deskripsi" value="{{ $tugas->deskripsi }}" required>
                        <input type="date" name="tanggal_target" value="{{ $tugas->tanggal_target }}" required>
                        <button type="submit">Edit</button>
                    </form>
                @endif
                
                <form action="/tugas/{{ $tugas->id }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>