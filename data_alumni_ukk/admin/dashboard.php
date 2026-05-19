<?php
session_start();
include __DIR__ . '/../koneksi.php';
if ($_SESSION['role'] != "admin") {
    header("Location: ./auth/login.php");
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Minecraft Edition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <style>
        .font-craft { font-family: 'Press Start 2P', monospace; }
        .font-pixel { font-family: 'VT323', monospace; }
    </style>
</head>

<body class="bg-zinc-800 text-neutral-200 min-h-full font-pixel text-xl flex flex-col m-0 p-0 relative selection:bg-green-600">

    <div class="absolute inset-0 z-0 bg-[linear-gradient(45deg,#2c2c2c_25%,transparent_25%),linear-gradient(-45deg,#2c2c2c_25%,transparent_25%),linear-gradient(45deg,transparent_75%,#2c2c2c_75%),linear-gradient(-45deg,transparent_75%,#2c2c2c_75%)] bg-[size:40px_40px] bg-zinc-900 opacity-40 pointer-events-none"></div>

    <header class="relative z-50">
        <nav class="fixed top-0 left-0 w-full bg-zinc-900 text-white py-3 px-4 border-b-4 border-black shadow-md">
            <div class="container mx-auto max-w-7xl flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <h1 class="text-xs font-craft tracking-tight text-yellow-400 drop-shadow-[2px_2px_0px_rgba(0,0,0,1)]">ALUMNI PANEL</h1>
                    <span class="text-xs font-bold uppercase bg-green-700 px-2 py-0.5 border-2 border-black text-white shadow-[2px_2px_0px_0px_rgba(0,0,0,0.5)]">ADMIN</span>
                </div>

                <div class="flex flex-wrap items-center justify-center md:justify-end gap-5 w-full md:w-auto">
                    <div class="flex items-center gap-4 text-lg font-bold uppercase tracking-wider">
                        <a href="./dashboard.php" class="py-1 text-yellow-400 border-b-4 border-yellow-400">Dashboard</a>
                        <a href="./create.php" class="text-zinc-400 hover:text-white py-1 transition-colors">Tambah_Data</a>
                    </div>

                    <div class="flex items-center gap-2.5 w-full sm:w-auto justify-center">
                        <div class="bg-zinc-700 text-yellow-300 py-1.5 px-3 border-2 border-black flex items-center gap-2 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.4)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <p><?= $_SESSION['username'] ?></p>
                        </div>
                        <a href="../logout.php" class="border-2 border-black bg-red-800 hover:bg-red-700 text-white py-1.5 px-3 font-bold transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,0.4)] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 17 5-5-5-5" />
                                <path d="M21 12H9" />
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            </svg>
                            <p>LOGOUT</p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto max-w-7xl pt-28 pb-12 px-4 relative z-10 flex-1">

        <div id="content"></div>

        <div class="bg-zinc-700 p-4 border-4 border-zinc-950 shadow-[6px_6px_0px_0px_rgba(0,0,0,0.5)] mb-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 relative before:absolute before:inset-0 before:border-2 before:border-zinc-500 before:pointer-events-none">

            <div class="flex-1 max-w-2xl">
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <input type="text" name="cari" placeholder="Cari alumni / jurusan / angkatan..."
                            value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>"
                            class="w-full pl-4 pr-4 py-2 bg-zinc-900 border-4 border-zinc-950 text-yellow-100 placeholder-zinc-500 focus:outline-none focus:border-green-500 transition-all">
                    </div>
                    <button type="submit" class="bg-zinc-500 hover:bg-zinc-400 text-white font-bold px-5 py-2 border-4 border-b-6 border-zinc-950 active:border-b-4 active:mt-0.5 cursor-pointer shadow-md">
                        CARI
                    </button>

                    <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                        <a href="dashboard.php" class="bg-red-800 hover:bg-red-700 text-white p-2 border-4 border-zinc-950 flex items-center justify-center shadow-md" title="Reset">
                            ✖
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="flex items-center justify-end">
                <a href="./create.php" class="w-full md:w-auto bg-green-700 hover:bg-green-600 text-white font-bold px-4 py-2.5 border-4 border-b-6 border-zinc-950 active:border-b-4 active:mt-0.5 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                    <span>+ TAMBAH ALUMNI</span>
                </a>
            </div>
        </div>

        <div class="bg-zinc-700 border-4 border-zinc-950 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.6)] overflow-hidden relative before:absolute before:inset-0 before:border-2 before:border-zinc-500 before:pointer-events-none">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-900 border-b-4 border-zinc-950 text-lg font-bold text-yellow-400 uppercase tracking-wider">
                            <th class="px-6 py-3 text-center w-20">ID</th>
                            <th class="px-6 py-3">Nama Lengkap</th>
                            <th class="px-6 py-3">Tahun Lulus</th>
                            <th class="px-6 py-3">Jurusan / Program Studi</th>
                            <th class="px-6 py-3 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-zinc-950 bg-zinc-800/50">

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
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr class='hover:bg-zinc-900/40 transition-colors text-xl text-zinc-200'>
                                     <td class='px-6 py-3 text-center font-bold text-zinc-500'>#{$data['id']}</td>
                                     <td class='px-6 py-3 font-bold text-white'>{$data['nama']}</td>
                                     <td class='px-6 py-3'>
                                         <span class='inline-block bg-zinc-900 text-green-400 px-2 py-0.5 border-2 border-zinc-950 font-bold'>
                                             {$data['angkatan']}
                                         </span>
                                     </td>
                                     <td class='px-6 py-3 text-zinc-300'>{$data['jurusan']}</td>
                                     <td class='px-6 py-3'>
                                         <div class='flex items-center justify-center gap-2'>
                                             <a href='./update.php?id={$data['id']}' class='bg-zinc-500 hover:bg-zinc-400 text-white font-bold py-1 px-3 border-2 border-b-4 border-black active:border-b-2 transition-all shadow-sm'>
                                                 Edit
                                             </a>
                                             <a href='./delete.php?id={$data['id']}' onclick=\"return confirm('Hancurkan data alumni ini?')\" class='bg-red-800 hover:bg-red-700 text-white font-bold py-1 px-3 border-2 border-b-4 border-black active:border-b-2 transition-all shadow-sm'>
                                                 Hapus
                                             </a>
                                         </div>
                                     </td>
                                 </tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <?php if (mysqli_num_rows($result) == 0): ?>
                <div class="p-8 text-center text-zinc-400 text-xl font-bold bg-zinc-800/20">
                    <p>📭 Tidak ada data alumni di dalam chunk ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-auto shrink-0 w-full bg-zinc-950 text-zinc-400 border-t-4 border-black p-6 relative">
        <div class="container mx-auto max-w-7xl flex flex-col justify-center gap-3 text-center">
            <h1 class="text-xs font-craft text-zinc-300 drop-shadow-[1px_1px_0px_rgba(0,0,0,1)]">MANAJEMEN DATA ALUMNI</h1>
            <p class="text-base font-normal text-zinc-500 max-w-2xl mx-auto leading-relaxed">
                Platform database internal untuk memetakan koordinat perkembangan karir alumni antar region angkatan.
            </p>
            <div class="border-t border-zinc-900 my-2 w-full max-w-md mx-auto"></div>
            <p class="text-sm font-bold text-zinc-600">&copy; 2026 <span class="text-green-700">[ Tim azam ]</span></p>
        </div>
    </footer>

</body>
</html>