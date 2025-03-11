<?php
include 'koneksi.php';
?>

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
<nav class="navbar navbar-expand-lg bg-warning " style="border-bottom: 5px solid  #ff8838;">
    <div class="container-fluid">
    <?php
        if (isset($_SESSION['user_id'])) {
          echo '<a class="navbar-brand text-white fw-bold" href="?page=welcome">';
            echo '<h1 class="mb-0"><i class="bi bi-robot text-white"></i><b>&nbsp; Robotors</b></h1>';
          echo '</a>';
        } else {
          echo '<a class="navbar-brand text-white fw-bold" href="?page=home">';
            echo '<h1 class="mb-0"><i class="bi bi-robot text-white"></i><b>&nbsp; Robotors</b></h1>';
          echo '</a>';
        }
      ?>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
        <ul class="navbar-nav me-3 my-2 my-lg-0 navbar-nav-scroll">
          <li class="nav-item">
            <?php
            if (isset($_SESSION['user_id'])) {
              $user_id = $_SESSION['user_id'];
              
              // Ambil role user dari database
              $query = "SELECT role.role FROM tb_users JOIN role ON tb_users.role_id = role.id WHERE tb_users.id = ?";
              $stmt = $connect->prepare($query);
              $stmt->bind_param("i", $user_id);
              $stmt->execute();
              $result = $stmt->get_result();
              $row = $result->fetch_assoc();
              $role = $row['role'] ?? 'user'; // Default ke user jika tidak ditemukan
              
              if ($role === 'admin') {
                  echo '<a class="nav-link text-white" href="?page=vidio" style="font-size: 20px;">Video</a>';
              } else {
                  echo '<a class="nav-link text-white" href="?page=welcome" style="font-size: 20px;">Home</a>';
              }
          } else {
              echo '<a class="nav-link text-white" href="?page=home" style="font-size: 20px;">Home</a>';
          }
            ?>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" style="font-size: 20px;">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" style="font-size: 20px;">About Us</a>
          </li>
          <?php
            if (isset($_SESSION['user_id'])){
          echo '<li class="nav-item dropdown">';
            echo '<a class="nav-link dropdown-toggle text-white btn btn-custom" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="font-size: 20px;">
              Profile';
            echo '</a>';
              echo '<ul class="dropdown-menu">';
              echo '<li><a class="dropdown-item" href="#">Account</i></a></li>';
              echo '<li>';
                echo '<hr class="dropdown-divider">'; 
              echo '</li>';
              echo '<li><a class="dropdown-item" href="?logout=true">Logout</a></li>';
            echo '</ul>';
            }else{
            echo '<a href="?page=login" class="btn btn-custom">Login Here <i class="bi bi-arrow-right"></i></a>';
            }

            if (isset($_GET['logout'])){
              session_destroy();
              header("Location: index.php?page=home"); 
              exit;
            }
            ?>

          </li>
        </ul>
        </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>
</html>