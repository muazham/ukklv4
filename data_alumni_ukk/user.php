<?php
session_start();
include 'koneksi.php';
if ($_SESSION['role'] != "user") {
    header('location: ./auth/login.php');
    header('location: ./auth/register.php');
    exit();
}

// Ambil jumlah total alumni untuk ditampilkan sebagai statistik kecil
$hitung_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alumni");

if (!$hitung_total) {
    die("Query Error: " . mysqli_error($koneksi));
}

$row_total = mysqli_fetch_assoc($hitung_total);
$total_alumni = $row_total['total'];
?>


<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Data Alumni</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[url('./img/backgroud_telkom.jpeg')] bg-cover bg-center bg-no-repeat bg-fixed text-neutral-900 min-h-full font-sans antialiased flex flex-col m-0 p-0">

    <header>
        <nav class="fixed top-0 left-0 w-full bg-red-600 text-white py-3.5 px-4 shadow-md z-50">
            <div class="container mx-auto max-w-7xl flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-bold tracking-tight">Manajemen Data Alumni</h1>
                    <span class="hidden sm:inline-block text-[10px] font-semibold uppercase tracking-wider bg-white/15 px-2 py-0.5 rounded border border-white/10">User Panel</span>
                </div>

                <div class="flex flex-wrap items-center justify-center md:justify-end gap-4 w-full md:w-auto">
                    <div class="flex items-center gap-2.5 w-full sm:w-auto justify-center">
                        <div class="bg-white text-neutral-900 py-1.5 px-3 text-xs font-semibold rounded border border-neutral-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <p><?= $_SESSION['username'] ?></p>
                        </div>
                        <a href="logout.php" class="border border-white/30 bg-white/10 hover:bg-white hover:text-red-600 text-xs py-1.5 px-3 font-semibold rounded transition-colors duration-150 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 17 5-5-5-5" />
                                <path d="M21 12H9" />
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            </svg>
                            <p>Logout</p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto max-w-7xl pt-24 pb-12 px-4 flex-1">

        <div id="content"></div>

        <div class="bg-white p-5 rounded-md shadow-sm border border-neutral-200 mb-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">

            <div class="flex-1 max-w-2xl">
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </div>
                        <input type="text" name="cari" placeholder="Cari Nama / Tahun Lulus / Jurusan..."
                            value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>"
                            class="w-full pl-9 pr-4 py-2 bg-white border border-neutral-300 rounded-md text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-neutral-900 focus:ring-1 focus:ring-neutral-900 transition-all duration-150" required>
                    </div>
                    <button type="submit" class="bg-neutral-900 hover:bg-neutral-800 text-white font-semibold text-sm px-4 py-2 rounded-md cursor-pointer transition-colors">
                        Cari
                    </button>

                    <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                        <a href="user.php" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-600 p-2 rounded-md transition-colors border border-neutral-300 flex items-center justify-center" title="Reset Pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="flex items-center gap-2 self-start md:self-auto bg-neutral-50 border border-neutral-200 px-3 py-1.5 rounded-md">
                <span class="w-2 h-2 rounded-full bg-neutral-900"></span>
                <p class="text-xs font-semibold text-neutral-600 uppercase tracking-wider">
                    Total Terdata: <span class="text-neutral-900 font-bold ml-1"><?= $total_alumni ?> Alumni</span>
                </p>
            </div>

        </div>

        <div class="bg-white rounded-md shadow-sm border border-neutral-200 overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 border-b border-neutral-200 text-xs font-bold text-neutral-600 uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-center w-20">No</th>
                            <th class="px-6 py-3.5">Nama Lengkap</th>
                            <th class="px-6 py-3.5">Tahun Lulus</th>
                            <th class="px-6 py-3.5">Jurusan/Program Studi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">

                        <?php
                        if (isset($_GET['cari'])) {
                            $cari = $_GET['cari'];
                            $result = mysqli_query($koneksi, "SELECT * FROM alumni
                                 WHERE nama LIKE '%$cari%'
                                 OR angkatan LIKE '%$cari%'
                                 OR jurusan LIKE '%$cari%'");
                        } else {
                            $result = mysqli_query($koneksi, "SELECT * FROM alumni");
                        }
                        ?>

                        <?php
                        $no = 1; // Variabel pembantu nomor urut agar rapi dan tidak melompat berdasarkan ID database
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr class='hover:bg-neutral-50/60 transition-colors duration-100 text-sm text-neutral-800'>
                                     <td class='px-6 py-3.5 text-center font-semibold text-neutral-400'>{$no}</td>
                                     <td class='px-6 py-3.5 font-semibold text-neutral-900'>{$data['nama']}</td>
                                     <td class='px-6 py-3.5'>
                                         <span class='inline-flex items-center bg-neutral-100 text-neutral-800 text-xs px-2 py-0.5 rounded font-semibold border border-neutral-200'>
                                             {$data['angkatan']}
                                         </span>
                                     </td>
                                     <td class='px-6 py-3.5 text-neutral-600'>{$data['jurusan']}</td>
                                 </tr>";
                            $no++;
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <?php if (mysqli_num_rows($result) == 0): ?>
                <div class="p-8 text-center text-neutral-400 text-sm font-medium">
                    <p>Tidak ada data alumni yang ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-auto shrink-0 w-full bg-neutral-950 text-neutral-400 border-t border-neutral-900">
        <div class="pt-6 py-1">
            <div class="container mx-auto max-w-7xl flex flex-col justify-center gap-3 px-4">
                <h1 class="text-xl text-center font-bold text-white tracking-tight">Manajemen Data Alumni</h1>
                <p class="text-xs text-center font-normal text-neutral-400 max-w-2xl mx-auto leading-relaxed">
                    Platform penelusuran data alumni untuk memetakan perkembangan karir, mempererat jejaring komunikasi, dan berbagi inspirasi antar angkatan.
                </p>
            </div>
        </div>

        <hr class="border-t border-neutral-900 mt-5 mb-4 w-full max-w-4xl mx-auto" />

        <div class="pb-5 flex-col text-center text-[11px] text-neutral-500 tracking-wide">
            <p class="font-medium">&copy; 2026 <span class="text-neutral-600">Tim azam</span></p>
        </div>
    </footer>

</body>

</html>