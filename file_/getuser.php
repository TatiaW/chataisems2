<?php
header("Content-Type: application/json"); // Format respons JSON

// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Query untuk mengambil semua user
$sql = "SELECT * FROM tb_users"; // Ganti 'users' dengan nama tabel Anda
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; 
    }
    echo json_encode(["status" => "success", "data" => $users]);
} else {
    echo json_encode(["status" => "success", "data" => []]); // Kosong jika tidak ada user
}

$conn->close();
?>