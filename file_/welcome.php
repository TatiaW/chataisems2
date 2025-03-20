<?php
include '_parcials/_template/header.php';
include_once './controllers/AuthController.php';

if (isset($_SESSION['success_message'])) {
  echo '<div id="alertBox" class="alert alert-success " role="alert">
          ' . $_SESSION['success_message'] . '
        </div>';
  unset($_SESSION['success_message']); 
}
//upload komentar komen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
  if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $is_approved = 1;
    $create_at = date('Y-m-d H:i:s');
        // Memasukkan data
        $query_insert = "INSERT INTO tb_comment (id_users,comment,is_approved,created_at) 
                        VALUES (?, ?, ?, ?)";
        $stmt_insert = $connect->prepare($query_insert);
        $stmt_insert->bind_param("isis",$user_id,$comment,$is_approved,$create_at);
  
        if ($stmt_insert->execute()) {
          $_SESSION['success_message'] = '<div id="alertBox" class=" alert-danger" role="alert">
                        Komentarmu Telah Di Posting
                    </div>';
            header("Location: index.php?page=welcome"); 
            // var_dump($_POST, $_SESSION, $user_id);
            exit();
        } else {
            echo "<script>alert('gagal, Cak ulangi');</script>";
        }
  
        $stmt_insert->close();
    }
}
$AuthController = new AuthController($connect);
// $adminController->checkAdminAccess();

$userData = $AuthController->getUserData();
// $profile_image = $userData['image'];
// $show_upload_modal = empty($profile_image);

?>

<body>
    
<!-- Jumbroton -->
  <div class="container mt-4">
    <div class="custom-container p-5 text-dark d-flex align-items-center position-relative">
        <div>
            <h1 style="font-size: 60px;"><b>Welcome <?php echo $userData['prefix']. " " .htmlspecialchars($userData['fullname']); ?></b></h1>

            <p class="text-muted">Gunakan Futuristik AI chatbot di lokal server kamu,<br />Layanan Chat bot virtual yang
                bisa kamu gunain untuk bisnis sehari-hari bisa integrasi langsung di aplikasi kamu</p>
        </div>
    </div>
</div>
  
<!-- Features Section -->
<div class="container mt-5">
  <h2 class="mb-3 fw-bolder">Robotors High Capabilities</h2>
  <p>Due to high request of AI, the next generation AI Chatbot has been created to be reusable in code optimization in Aurora Server</p>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      
      <!-- Feature 1 -->
      <div class="col">
          <div class="card p-4 bg-light feature-card">
              <i class="bi bi-robot text-primary fs-1"></i>
              <h5 class="mt-3"><b>AI Chatbot</b></h5>
              <p>Super Charge AI Chatbot for Developers, whatever you based on, just hover the chats while stuck, buddy...</p>
          </div>
      </div>

      <!-- Feature 2 -->
      <div class="col">
          <div class="card p-4 bg-light feature-card">
              <i class="bi bi-shield-lock text-danger fs-1"></i>
              <h5 class="mt-3"><b>Security</b></h5>
              <p>Starvee AI Secure features and anti-fraud system will detect anomaly access, whatever you are, wherever you are.</p>
          </div>
      </div>

      <!-- Feature 3 -->
      <div class="col">
          <div class="card p-4 bg-light feature-card">
              <i class="bi bi-speedometer2 text-success fs-1"></i>
              <h5 class="mt-3"><b>Fastest Response</b></h5>
              <p>You won't get stuck while AI is developing your product code, just think 0.2 seconds and you will be happy in no time.</p>
          </div>
      </div>

      <!-- Feature 4 -->
      <div class="col">
          <div class="card p-4 bg-light feature-card">
              <i class="bi bi-cloud-arrow-down text-warning fs-1"></i>
              <h5 class="mt-3"><b>Cloud Options</b></h5>
              <p>Starvee engine offers Cloud Options to collect the dataset once you submit, and it will be reusable in all your projects.</p>
              <form method="post">
                <input type="text" name="comment" class="form-control mb-2" placeholder="Masukkan komentar anda" required>
                <button name="submit_comment" class="btn w-100 btn-gold" type="submit">Kirim</button>
              </form>
          </div>
      </div>
  </div>
</div>


  
  <!-- Footer -->
    <?php
    include '_parcials/_template/footer.php';
    ?>
  <!-- <footer class=" text-white mt-5 py-4" style="background-color: #c4876a;">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>About Us</h5>
          <p>We provide cutting-edge AI solutions for businesses and developers.</p>
        </div>
        <div class="col-md-4">
          <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Home</a></li>
            <li><a href="#" class="text-white">Pricing</a></li>
            <li><a href="#" class="text-white">Documentation</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Contact Us</h5>
          <p>Email: support@robotors.ai<br>Phone: +123 456 7890</p>
        </div>
      </div>
      <div class="text-center mt-3">
        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
        <a href="#" class="text-white me-3"><i class="bi bi-linkedin"></i></a>
        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
      </div>
      <div class="text-center mt-3">
        <p>&copy; 2025 Robotors AI. All rights reserved.</p>
      </div>
    </div>
  </footer> -->
  <script>
    // Menghapus alert setelah 10 detik
    setTimeout(function() {
        var alertBox = document.getElementById("alertBox");
        if (alertBox) {
            alertBox.style.transition = "opacity 1s";
            alertBox.style.opacity = "0";
            setTimeout(function() { alertBox.remove(); }, 1000); 
        }
    }, 10000);
</script>
</body>
</html>