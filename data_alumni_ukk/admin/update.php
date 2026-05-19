<?php
session_start();
include __DIR__ . '/../koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM alumni WHERE id='$id'"));
if (isset($_POST['update'])) {
    $sql = "UPDATE alumni SET 
    nama='$_POST[nama]',
    angkatan='$_POST[angkatan]',
    jurusan='$_POST[jurusan]'
    WHERE id='$id'";

    mysqli_query($koneksi, $sql);
    header("location: ./dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update - Manajemen Data Alumni</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[url('../img/backgroud_telkom.jpeg')] bg-cover bg-center bg-no-repeat bg-fixed text-neutral-900 min-h-full font-sans antialiased flex flex-col m-0 p-0">
    <main class="container mx-auto max-w-xl pt-16 pb-16 px-4 flex-1 flex flex-col justify-center">

        <div class="mb-4">
            <a href="./dashboard.php" class="inline-flex items-center gap-1.5 text-xs font-bold text-neutral-700 hover:text-neutral-900 bg-white/60 backdrop-blur-xs px-2.5 py-1 rounded border border-neutral-300/50 transition-colors duration-150 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:-translate-x-0.5">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <div class="bg-white p-8 rounded-md shadow-xs border border-neutral-200 relative overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-1 bg-red-600"></div>

            <h2 class="text-xl font-bold text-neutral-900 tracking-tight mb-5">Update Data Alumni</h2>

            <form action="" method="post" class="flex flex-col gap-4">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
            
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= $data['nama'] ?>" placeholder="Masukkan nama lengkap" required
                        class="w-full px-3 py-2 bg-white border border-neutral-300 rounded-md text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900 transition-all duration-150">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider">Tahun Lulus</label>
                    <input type="text" name="angkatan" value="<?= $data['angkatan'] ?>" placeholder="Contoh: 2025" required
                        class="w-full px-3 py-2 bg-white border border-neutral-300 rounded-md text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900 transition-all duration-150">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider">Jurusan / Program Studi</label>
                    <div class="relative">
                        <select name="jurusan" required
                            class="w-full px-3 py-2 bg-white border border-neutral-300 rounded-md text-sm text-neutral-900 focus:outline-none focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900 transition-all duration-150 appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            <option value="Rekayasa Perangkat Lunak" <?= ($data['jurusan'] == 'Rekayasa Perangkat Lunak') ? 'selected' : '' ?>>Rekayasa Perangkat Lunak</option>
                            <option value="Teknik Komputer dan Jaringan" <?= ($data['jurusan'] == 'Teknik Komputer dan Jaringan') ? 'selected' : '' ?>>Teknik Komputer dan Jaringan</option>
                            <option value="Teknik Jaringan Akses Telekomunikasi" <?= ($data['jurusan'] == 'Teknik Jaringan Akses Telekomunikasi') ? 'selected' : '' ?>>Teknik Jaringan Akses Telekomunikasi</option>
                            <option value="Animasi" <?= ($data['jurusan'] == 'Animasi') ? 'selected' : '' ?>>Animasi</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" name="update" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-2.5 px-4 rounded-md shadow-sm transition-colors duration-150 flex items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        <span>Update Data Alumni</span>
                    </button>
                </div>

                <div class="empty:hidden [&>p]:mt-2 [&>p]:p-3 [&>p]:bg-neutral-100 [&>p]:border [&>p]:border-neutral-200 [&>p]:rounded-md [&>p]:text-neutral-800 [&>p]:text-xs [&>p]:font-semibold [&>p]:flex [&>p]:items-center [&>p]:justify-between [&>p_a]:bg-neutral-900 [&>p_a]:text-white [&>p_a]:px-2.5 [&>p_a]:py-1 [&>p_a]:rounded [&>p_a]:font-bold [&>p_a]:hover:bg-neutral-850 [&>p_a]:transition-colors [&>p_a]:no-underline">
                </div>

            </form>
        </div>
    </main>
</body>

</html>