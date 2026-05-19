<?php
session_start();
include __DIR__ . '/../koneksi.php';

// memeriksa btn registrasi telah di tekan(kirim)
if (isset($_POST['registrasi'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $insert = mysqli_query($koneksi, "INSERT INTO users (username,password,role) VALUES ('$username','$password','user')");

    // $hash_password = password_hash($password, PASSWORD_DEFAULT);
    if ($insert) {
        // jika insert berhasil , langsung set session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = "user";

        header('location: ../user.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Minecraft Edition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <style>
        .font-craft { font-family: 'Press Start 2P', monospace; }
        .font-pixel { font-family: 'VT323', monospace; }
    </style>
</head>

<body class="text-neutral-200 min-h-screen flex items-center justify-center font-pixel text-xl p-4 relative overflow-hidden bg-zinc-900 selection:bg-green-600">

    <div class="absolute inset-0 -z-30 filter blur-[4px] scale-105">
        <div id="bg-slide-1" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100"></div>
        <div id="bg-slide-2" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0"></div>
    </div>

    <div class="absolute inset-0 bg-zinc-950/70 -z-20"></div>

    <main class="w-full max-w-md relative z-10">

        <form action="register.php" method="post"
            class="bg-zinc-700 p-6 border-4 border-zinc-950 shadow-[10px_10px_0px_0px_rgba(0,0,0,0.6)] flex flex-col gap-5 relative before:absolute before:inset-0 before:border-2 before:border-zinc-500 before:pointer-events-none">

            <div class="flex flex-col items-center text-center gap-3 mb-2 border-b-4 border-zinc-900 pb-4">
                <img src="../img/logo.png" alt="Logo SMK Telkom" class="w-16 h-16 object-contain border-4 border-zinc-950 bg-white p-1 shadow-md">

                <div class="flex flex-col gap-1">
                    <h1 class="text-xs font-craft tracking-tight text-yellow-400 drop-shadow-[2px_2px_0px_rgba(0,0,0,1)] leading-relaxed">
                        MANAJEMEN DATA ALUMNI
                    </h1>
                    <div class="mt-1">
                        <span class="text-base font-bold bg-zinc-900 text-zinc-300 px-3 py-1 border-2 border-zinc-950 shadow-sm">
                            SMK TELKOM LAMPUNG
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-lg font-bold text-green-400 uppercase tracking-wider">Username Baru</label>
                <input type="text" name="username" placeholder="Buat Username..."
                    class="w-full px-3 py-2 border-4 border-zinc-950 bg-zinc-900 text-yellow-100 placeholder-zinc-600 focus:outline-none focus:border-green-500 transition-all" required>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-lg font-bold text-green-400 uppercase tracking-wider">Password Baru</label>
                <input type="password" name="password" placeholder="Buat Password..."
                    class="w-full px-3 py-2 border-4 border-zinc-950 bg-zinc-900 text-yellow-100 placeholder-zinc-600 focus:outline-none focus:border-green-500 transition-all" required>
            </div>

            <div class="flex flex-col gap-4 mt-2">
                <button type="submit" name="registrasi"
                    class="w-full bg-zinc-500 hover:bg-green-700 text-white font-bold py-3 px-4 border-4 border-b-8 border-zinc-950 active:border-b-4 active:mt-1 cursor-pointer text-center tracking-wide text-xl shadow-md transition-all">
                    DAFTAR AKUN BARU
                </button>

                <div class="w-full h-1 bg-zinc-900"></div>

                <p class="text-base text-zinc-400 text-center font-bold">
                    Sudah terdaftar? 
                    <a href="login.php" class="text-yellow-400 hover:text-green-400 underline transition-colors ml-1">
                        Masuk disini
                    </a>
                </p>
            </div>

        </form>

    </main>

    <script>
        const images = [
            '../img/backgroud_telkom.jpeg',
            '../img/bg3.png',
            '../img/bg1.jpg',
            '../img/bg2.jpg'
        ];

        let currentIndex = 0;
        const slide1 = document.getElementById('bg-slide-1');
        const slide2 = document.getElementById('bg-slide-2');

        slide1.style.backgroundImage = `url('${images[0]}')`;
        slide2.style.backgroundImage = `url('${images[1]}')`;

        let isSlide1Active = true;

        function changeBackground() {
            currentIndex = (currentIndex + 1) % images.length;
            const nextImage = images[currentIndex];

            if (isSlide1Active) {
                slide2.style.backgroundImage = `url('${nextImage}')`;
                slide1.classList.replace('opacity-100', 'opacity-0');
                slide2.classList.replace('opacity-0', 'opacity-100');
            } else {
                slide1.style.backgroundImage = `url('${nextImage}')`;
                slide2.classList.replace('opacity-100', 'opacity-0');
                slide1.classList.replace('opacity-0', 'opacity-100');
            }
            isSlide1Active = !isSlide1Active;
        }

        setInterval(changeBackground, 4000); 
    </script>
</body>
</html>