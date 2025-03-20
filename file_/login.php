<?php 
include '_parcials/_template/header.php';
include_once './controllers/AuthController.php';

$auth = new AuthController($connect);
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
<main class="container">
    <div class="container-fluid vh-90 " style="margin-top: 5rem; ">
        <div class="row h-100 justify-content-center" >
            <!-- Kolom Kiri: Logo -->
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center bg-transparent">
                <img src="./img/chatbot.png" alt="Logo" class="img-fluid" style="max-width: 30%; margin-bottom: 20px;">
                <h1 class="text-center">Robotors</h1>
            </div>
    
            <!-- Kolom Kanan: Form Login/Register -->
            <div class="col-lg-4 d-flex shadow-lg rounded-4 align-items-center justify-content-center p-4 mx-auto" style="border: 1px solid #ff8838;">
                <main class="form-signin w-75" >
                    <form method="POST" action="?page=login" >
                        <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
    
                        <div class="form-floating">
                            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                            <label for="floatingInput">Username/Email</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
    
                        <button class="btn btn-primary w-100 py-2 mt-3" type="submit" name="login">Login</button>
                        
                        <div class="text-center mt-3">
                            Belum memiliki akun? <a href="?page=register">Register</a>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
</main>



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