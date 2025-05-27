<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Robotors</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include koneksi database
include 'config/db.php';

// Ambil data foto profil jika user sudah login
$profile_image = 'img/Foto Profil Default.jpg'; // Default image
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT image FROM tb_users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image'])) {
            $profile_image = $row['image'];
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<nav class="navbar navbar-expand-lg bg-warning" style="border-bottom: 5px solid #ff8838;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold ms-5" href="?page=home">
            <h1 class="mb-0"><i class="bi bi-robot text-white"></i><b>&nbsp; Robotors</b></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
            <ul class="navbar-nav me-3 my-2 my-lg-0 navbar-nav-scroll">
                <li class="nav-item">
                    <a class="nav-link active fw-medium text-white" href="?page=home" style="font-size: 20px;">Home</a>
                </li>
                  <?php if (isset($_SESSION['user_id'])) : ?>
                <li class="nav-item">
                    <a class="nav-link active fw-medium text-white" href="?page=admin_dashboard" style="font-size: 20px;">Dashboard</a>
                </li>
                
              
                <li class="nav-item dropdown me-5">
                    <a class="nav-link active fw-medium fs-5 dropdown-toggle text-white" href="#" role="button" 
                        data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" 
                             alt="Profile" 
                             class="rounded-circle" 
                             style="width: 40px; height: 40px; object-fit: cover; margin-left: 10px;">
                        <?= ucwords(htmlspecialchars($_SESSION['fullname'])) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?page=manage_users">Profil</a></li>
                        <li><a class="dropdown-item" href="?page=logout">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a href="?page=login" class="btn btn-custom">Login Here <i class="bi bi-arrow-right"></i></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>
</html>