
<!-- file_/admin_dashboard.php -->
<head>
  <link rel="stylesheet" href="./css/style.css">
</head>
<?php

include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: index.php?page=login");
    exit();
}
?>
<div class="container mt-5">
    <h1>Welcome, Administrator <?php echo $_SESSION['fullname'];?>!</h1>
    <p>This is the admin dashboard.</p>
    
</div>
