<?php 
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? (int)$_POST['jenis_kelamin'] : null; // Ensure it's an integer
    $no_telp = isset($_POST['no_telp']) ? $_POST['no_telp'] : ''; // Check if no_telp is set
    $alamat = $_POST['alamat'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $image = isset($_POST['image']) && !empty($_POST['image']) ? $_POST['image'] : '';
    $role_id = 1; // Default role ID, adjust as necessary
    $created_at = date('Y-m-d H:i:s');
    $update_at =date('Y-m-d H:i:s') ; // Set to null initially
    

    // Check if email already exists
    $query_check = "SELECT * FROM tb_users WHERE email = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script> alert ('Maaf email sudah terdaftar');</script>";
        echo '<meta http-equiv="refresh" content="0.8; url=?page=register">';
    } else {
        // Insert data
        $query_insert = "INSERT INTO tb_users (fullname, email, password, jenis_kelamin, no_telp, alamat, image, role_id, created_at, update_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bind_param("ssssssisss", $fullname, $email, $password, $jenis_kelamin, $no_telp, $alamat,$image, $role_id, $created_at, $update_at);

                // Jalankan pernyataan insert
                if ($stmt_insert->execute()) {
                    echo "<script> alert ('Daftar Berhasil, Silahkan Login !!');</script>";
                    echo '<meta http-equiv="refresh" content="0.8; url=?page=login">';
                } else {
                    echo "<script> alert ('Terjadi kesalahan saat mendaftar: " . $stmt_insert->error . "');</script>";
                }
            }
        
    

    $stmt_check->close();
    $conn->close();
}
?>
<head>
  <link rel="stylesheet" href="././css/style.css">

</head>
<body style="background-color: beige;" >
     

  <!--Login-->
    <div class="container-fluid vh-90 " style="margin-top: 1rem;">
        <div class="row h-100" >
            <!-- Kolom Kiri: Logo -->
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center bg-transparent">
                <img src="./img/chatbot.png" alt="Logo" class="img-fluid" style="max-width: 30%; margin-bottom: 20px;">
                <h1 class="text-center">Robotors</h1>
            </div>
    
            <!-- Kolom Kanan: Form Login/Register -->
            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <main class="form-signin w-75" >
                     <form method="POST">
                        <h1 class="h3 mb-3 fw-normal text-center">Register</h1>

                        <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email</label>
                        </div>
                    <div class="form-floating mt-1">
                        <input type="text" name="fullname" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mt-1">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mt-1">
                        <select name="jenis_kelamin" class="form-control" id="floatingGender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                        <label for="floatingGender">Jenis Kelamin</label>
                    </div>
                    <div class="form-floating mt-1">
                        <input type="tel" name="no_telp" class="form-control" id="floatingPhone" placeholder="No Telepon" required>
                        <label for="floatingPhone">No Telepon</label>
                    </div>
                    <div class="form-floating mt-1">
                        <textarea name="alamat" class="form-control" id="floatingAddress" placeholder="Alamat" required></textarea>
                        <label for="floatingAddress">Alamat</label>
                    </div>


                        <button class="btn btn-primary w-100 py-2 mt-3" type="submit" name="register">Register</button>

                        <div class="text-center mt-3">
                            Sudah memiliki akun? <a href="?page=login">Login</a>
                        </div>
                    </form>
                </main>

            </div>
        </div>
    </div>
    <?php include '_parcials/_template/footer.php';?>