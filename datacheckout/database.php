<?php
session_start();

// Koneksi ke database
$servername = "localhost"; // Ganti dengan hostname database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "web_parfum"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $item_type = $_POST['item_type'];
    $quantity = $_POST['quantity'];

    // Query untuk menyimpan data ke tabel checkout
    $sql = "INSERT INTO data_checkout (name, email, phone_number, address, city, postal_code, item_type, quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $email, $phone_number, $address, $city, $postal_code, $item_type, $quantity);

    if ($stmt->execute()) {
        echo "Checkout berhasil! Terima kasih atas pembelian Anda.";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
