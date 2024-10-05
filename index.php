<?php
session_start();

// Set durasi waktu session timeout (1 menit)
$session_timeout_0002 = 60;

// Cek apakah ada data session yang tersimpan dan waktu session masih berlaku
if (isset($_SESSION['result_time_0002'])) {
    $elapsed_time_0002 = time() - $_SESSION['result_time_0002'];
    if ($elapsed_time_0002 > $session_timeout_0002) {
        // Hapus session jika lebih dari 1 menit
        unset($_SESSION['result_0002'], $_SESSION['result_time_0002']);
    }
}

// Jika halaman di-refresh tanpa POST, maka hapus session
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    unset($_SESSION['result_0002'], $_SESSION['result_time_0002']);
}

// Jika form dikirim (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['total_belanja_0002']) && isset($_POST['member_0002'])) {
        // Ambil data dari form
        $total_belanja_0002 = $_POST['total_belanja_0002'];
        $member_0002 = $_POST['member_0002'];

        // Fungsi untuk menghitung diskon
        function hitungDiskon_0002($total_belanja_0002, $member_0002) {
            $diskon_0002 = 0;
            $diskon_member_0002 = $total_belanja_0002 - 0.10 * $total_belanja_0002;

            if ($member_0002) {
                // Jika member
                if ($total_belanja_0002 > 1000000) {
                    $diskon_0002 = 0.10 * $total_belanja_0002 + 0.15 * $diskon_member_0002;
                } elseif ($total_belanja_0002 >= 500000) {
                    $diskon_0002 = 0.10 * $total_belanja_0002 + 0.10 * $total_belanja_0002;
                } else {
                    $diskon_0002 = $diskon_member_0002;
                }
            } else {
                // Jika bukan member
                if ($total_belanja_0002 > 1000000) {
                    $diskon_0002 = 0.10 * $total_belanja_0002;
                } elseif ($total_belanja_0002 >= 500000) {
                    $diskon_0002 = 0.05 * $total_belanja_0002;
                }
            }

            // Total bayar setelah diskon
            $total_bayar_0002 = $total_belanja_0002 - $diskon_0002;
            return array('total_belanja_0002' => $total_belanja_0002, 'diskon_0002' => $diskon_0002, 'total_bayar_0002' => $total_bayar_0002);
        }

        // Panggil fungsi untuk menghitung diskon
        $result_0002 = hitungDiskon_0002($total_belanja_0002, $member_0002);

        // Simpan hasil ke session
        $_SESSION['result_0002'] = $result_0002;
        $_SESSION['result_time_0002'] = time();
    } else {
        echo "Mohon lengkapi data pada form.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Diskon</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(270deg, #74ebd5, #acb6e5, #f7797d);
            background-size: 600% 600%;
            animation: bg-animation 10s ease infinite;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 500px;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Hitung Total Bayar</h1>
    <form method="POST">
        <label for="total_belanja_0002">Total Belanja (Rp):</label>
        <input type="text" id="total_belanja_0002" name="total_belanja_0002" required>

        <label for="member_0002">Apakah Anda Member?</label>
        <select id="member_0002" name="member_0002">
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>

        <input type="submit" value="Total Bayar">
    </form>

    <?php
    // Tampilkan hasil jika ada di session dan belum kedaluwarsa
    if (isset($_SESSION['result_0002'])) {
        echo "<div class='result_0002'>";
        echo "<p>Total Belanja: Rp " . number_format($_SESSION['result_0002']['total_belanja_0002'], 0, ',', '.') . "</p>";
        echo "<p>Diskon: Rp " . number_format($_SESSION['result_0002']['diskon_0002'], 0, ',', '.') . "</p>";
        echo "<p>Total Bayar: Rp " . number_format($_SESSION['result_0002']['total_bayar_0002'], 0, ',', '.') . "</p>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>