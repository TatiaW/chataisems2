<?php
if (isset($_SESSION['user_id'])){
  include_once './controllers/ProfilController.php';

  $ProfileController = new ProfilController($connect);
  
  $ProfileData = $ProfileController->getProfil();
  $profile_image = $ProfileData['image'];
  
  $profile_image = !empty($profile_image) ? 'upload/image/' . $profile_image : 'img/robot-ai.png';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Robotors - <?php echo ucfirst($page); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->



<style>
    html, body {
      height: 100%;
      display: flex;
      flex-direction: column;
  }

  main {
      flex: 1; /* Membuat konten utama mengisi ruang */
  }

  .chat-container {
            display: flex;
            height: 90vh;
        }
        .friends-list {
            width: 30%;
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }
        .chat-box {
            width: 70%;
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px;
        }
        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
        }
        .sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }
        .received {
            background-color: #e9ecef;
            align-self: flex-start;
        }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-warning shadow-lg" style="border-bottom: 2px solid  #ff8838;">
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
                    echo '<a class="nav-link text-white" href="?page=admin_dashboard" style="font-size: 20px;">Dashboard</a>';
                } else {
                    echo '<a class="nav-link text-white" href="?page=welcome" style="font-size: 20px;">Home</a>';
                }
            } else {
                echo '<a class="nav-link text-white" href="?page=home" style="font-size: 20px;">Home</a>';
            }
              ?>
            </li>
          <?php
          if (isset ($_SESSION['user_id'])){
            echo '<li class="nav-item">
            <a href="?page=meeting"class="nav-link text-white" style="font-size: 20px;">Meeting</a>
          </li> ';
          }
          ?>
          <?php
          if (isset ($_SESSION['user_id'])){
            echo '<li class="nav-item">
            <a href="?page=chatai"class="nav-link text-white" style="font-size: 20px;">Chat</a>
          </li> ';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link text-white" style="font-size: 20px;">About Us</a>
          </li>
          <?php
            if (isset($_SESSION['user_id'])){
            echo '<li class="nav-item dropdown">';
            echo '<a class="nav-link dropdown-toggle text-white btn btn-custom d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="font-size: 20px;">
                    <img src="'. htmlspecialchars($profile_image) . '" alt="Profile" class="rounded-circle me-2" width="30"> Profile';
            echo '</a>';
            echo '<ul class="dropdown-menu">';
            echo '<li><a class="dropdown-item" href="?page=account">Account</a></li>';
            echo '<li><hr class="dropdown-divider"></li>';
            echo '<li><a class="dropdown-item" href="?page=logout">Logout</a></li>';
            echo '</ul>';

            }else{
            echo '<a href="?page=login" class="btn btn-custom">Login Here <i class="bi bi-arrow-right"></i></a>';
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

