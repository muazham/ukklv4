<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Proteksi halaman: Pastikan hanya admin yang bisa menambah data
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header('location: ../auth/login.php');
    exit();
}

// Inisialisasi variabel pesan
$error_msg = "";

// Memeriksa apakah form telah dikirimkan menggunakan method POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil data dari form dan bersihkan dari karakter berbahaya
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    // Validasi sederhana agar memastikan semua field terisi
    if (!empty($nama) && !empty($angkatan) && !empty($jurusan)) {
        
        // Query INSERT disesuaikan dengan struktur tabel kamu (Id diabaikan karena AUTO_INCREMENT)
        $query = "INSERT INTO alumni (nama, angkatan, jurusan) VALUES ('$nama', '$angkatan', '$jurusan')";
        $insert = mysqli_query($koneksi, $query);

        if ($insert) {
            // Jika berhasil disimpan, alihkan ke dashboard admin
            header('location: dashboard.php');
            exit();
        } else {
            $error_msg = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
        }
    } else {
        $error_msg = "Semua kolom formulir wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Alumni - Minecraft Edition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <style>
        .font-craft { font-family: 'Press Start 2P', monospace; }
        .font-pixel { font-family: 'VT323', monospace; }
        /* Efek pixelated pada input select */
        select, input { image-rendering: pixelated; }
    </style>
</head>

<body class="bg-zinc-800 text-neutral-100 min-h-screen flex flex-col items-center justify-center p-4 relative m-0 font-pixel text-xl tracking-wide selection:bg-green-600">

    <div class="absolute inset-0 z-0 bg-[linear-gradient(45deg,#2c2c2c_25%,transparent_25%),linear-gradient(-45deg,#2c2c2c_25%,transparent_25%),linear-gradient(45deg,transparent_75%,#2c2c2c_75%),linear-gradient(-45deg,transparent_75%,#2c2c2c_75%)] bg-[size:40px_40px] bg-zinc-900 opacity-40"></div>

    <main class="w-full max-w-md relative z-10">
        
        <div class="mb-5">
            <a href="dashboard.php" class="inline-flex items-center gap-2 text-lg font-bold text-zinc-300 hover:text-white bg-zinc-700 hover:bg-zinc-600 px-4 py-2 border-2 border-b-4 border-r-4 border-black active:border-b-2 active:border-r-2 active:mt-0.5 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.4)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>
                [ Kembali ]
            </a>
        </div>

        <form action="create.php" method="POST" class="bg-zinc-700 p-6 border-4 border-zinc-950 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.6)] flex flex-col gap-5 relative before:absolute before:inset-0 before:border-4 before:border-zinc-500 before:pointer-events-none">
            
            <div class="text-center border-b-4 border-zinc-900 pb-3">
                <h1 class="text-sm font-craft tracking-tight text-yellow-400 drop-shadow-[2px_2px_0px_rgba(0,0,0,1)]">TAMBAH ALUMNI</h1>
                <p class="text-base text-zinc-400 mt-2 font-pixel">Isi data ke dalam inventory sistem.</p>
            </div>

            <?php if (!empty($error_msg)) : ?>
                <div class="bg-red-900 border-4 border-red-950 p-3 text-red-200 text-lg font-bold flex items-start gap-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.3)]">
                    <div>⚠️ <?= $error_msg; ?></div>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-1.5">
                <label class="text-lg font-bold text-green-400 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap..."
                    class="w-full px-3 py-2 border-4 border-zinc-950 bg-zinc-900 text-yellow-100 text-xl placeholder-zinc-500 focus:outline-none focus:border-green-500 transition-all" required>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-lg font-bold text-green-400 uppercase tracking-wider">Tahun Lulus</label>
                <input type="number" name="angkatan" placeholder="Contoh: 2025" min="1900" max="2100"
                    class="w-full px-3 py-2 border-4 border-zinc-950 bg-zinc-900 text-yellow-100 text-xl placeholder-zinc-500 focus:outline-none focus:border-green-500 transition-all" required>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-lg font-bold text-green-400 uppercase tracking-wider">Jurusan / Program Studi</label>
                <select name="jurusan" class="w-full px-3 py-2 border-4 border-zinc-950 bg-zinc-900 text-yellow-100 text-xl focus:outline-none focus:border-green-500 transition-all appearance-none cursor-pointer" required>
                    <option value="" disabled selected class="text-zinc-500">Pilih Jurusan</option>
                    <option value="Rekayasa Perangkat Lunak" class="bg-zinc-800 text-white">Rekayasa Perangkat Lunak</option>
                    <option value="Teknik Komputer dan Jaringan" class="bg-zinc-800 text-white">Teknik Komputer dan Jaringan</option>
                    <option value="Desain Komunikasi Visual" class="bg-zinc-800 text-white">Desain Komunikasi Visual</option>
                </select>
            </div>

            <div class="mt-2">
                <button type="submit" class="w-full bg-zinc-500 hover:bg-green-700 text-white font-bold py-3 px-4 border-4 border-b-8 border-zinc-950 hover:border-b-8 hover:border-zinc-950 text-xl cursor-pointer text-center tracking-wide flex items-center justify-center gap-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.4)] active:border-b-4 active:mt-1 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    SIMPAN DATA (ENTER)
                </button>
            </div>
        </form>
    </main>

</body>
</html>