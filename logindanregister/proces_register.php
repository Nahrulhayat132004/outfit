<?php
// Koneksi database
$conn = new mysqli('localhost', 'root', '', 'data-login');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form dan sanitasi input
$username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password']);

// Validasi input
if (empty($username) || empty($email) || empty($password)) {
    echo "Username, email, dan password harus diisi. <a href='register.php'>Coba lagi</a>";
    exit();
}

// Cek apakah email sudah terdaftar
$stmt = $conn->prepare("SELECT id FROM nama_login WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Email sudah terdaftar. <a href='register.php'>Coba lagi</a>";
    exit();
}
$stmt->close();

// Cek apakah username sudah digunakan
$stmt = $conn->prepare("SELECT id FROM nama_login WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Username sudah digunakan. <a href='register.php'>Coba lagi</a>";
    exit();
}
$stmt->close();

// Hash password sebelum disimpan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan data ke database
$stmt = $conn->prepare("INSERT INTO nama_login (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);
if ($stmt->execute()) {
    echo "Registrasi berhasil. <a href='login.php'>Login sekarang</a>";
} else {
    echo "Registrasi gagal: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
