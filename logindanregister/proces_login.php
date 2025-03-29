<?php
session_start(); // Mulai session

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'data-login');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die("⚠️ Email dan password harus diisi.");
    }

    // Ambil username dan password dari database
    $stmt = $conn->prepare("SELECT username, password FROM nama_login WHERE email = ?");
    if (!$stmt) {
        die("Query error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username, $stored_password);
        if ($stmt->fetch()) {
            // Cocokkan password yang di-hash
            if (password_verify($password, $stored_password)) {
                // Simpan session setelah user terautentikasi
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username; // ✅ Simpan username ke session

                session_write_close(); // Pastikan session tersimpan sebelum redirect
                header("Location: ../index.php");
                exit();
            } else {
                die("⚠️ Password salah. <a href='login.php'>Coba lagi</a>");
            }
        }
    } else {
        die("⚠️ Email tidak terdaftar. <a href='register.php'>Daftar sekarang</a>");
    }

    $stmt->close();
}
$conn->close();
?>
