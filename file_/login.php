<?php 
include 'config/db.php';
include_once 'controllers/AuthController.php';

$auth = new AuthController($conn);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = $auth->login($email, $password);
}
?>

<head>
  <link rel="stylesheet" href="././css/style.css">
</head>
<body style="background-color: beige;" >
     

  <!--Login-->
    <div class="container-fluid vh-90 " style="margin-top: 5rem;">
        <div class="row h-100" >
            <!-- Kolom Kiri: Logo -->
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center bg-transparent">
                <img src="./img/chatbot.png" alt="Logo" class="img-fluid" style="max-width: 30%; margin-bottom: 20px;">
                <h1 class="text-center">Robotors</h1>
            </div>
    
            <!-- Kolom Kanan: Form Login/Register -->
            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <main class="form-signin w-75" >
                    <form action="" method="POST" >
                        <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
    
                        <div class="form-floating">
                            <input type="email" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="password" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1 mb-4">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>

                        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Login</button>
                        
                        <div class="text-center mt-3">
                            Belum memiliki akun? <a href="?page=register">SignUp</a>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
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
    <?php include '_parcials/_template/footer.php';?>
  