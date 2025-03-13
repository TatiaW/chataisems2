
<!-- file_/admin_dashboard.php -->
<head>
  <link rel="stylesheet" href="./css/style.css">
</head>
<?php

include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: index.php?page=login");
    exit();
}
?>
<div class="container mt-5">
    <h1>Welcome, Administrator <?php echo $_SESSION['fullname'];?>!</h1>
    <p>This is the admin dashboard.</p>
    <a href="index.php?page=logout" class="btn btn-danger">Logout</a>
</div>
