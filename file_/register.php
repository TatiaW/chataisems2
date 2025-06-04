<?php 
include 'config/db.php';

// Pastikan folder uploads ada dan writable
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Sanitasi input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $fullname = htmlspecialchars($_POST['fullname']);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? ($_POST['jenis_kelamin'] === 'male' ? 1 : 0) : null;
    $no_telp = isset($_POST['no_telp']) ? preg_replace('/[^0-9]/', '', $_POST['no_telp']) : '';
    $alamat = htmlspecialchars($_POST['alamat']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role_id = 1;
    $created_at = date('Y-m-d H:i:s');
    $update_at = date('Y-m-d H:i:s');
    $image = ''; // Default value

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Validasi tipe file
        if (in_array($ext, $allowed_types)) {
            // Validasi ukuran file (max 5MB)
            if ($_FILES["image"]["size"] <= 5000000) {
                // Generate unique filename
                $filename = uniqid('profile_', true) . '.' . $ext;
                $target_path = 'uploads/' . $filename;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                    $image = $target_path;
                } else {
                    echo "<script>alert('Gagal menyimpan file upload');</script>";
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB)');</script>";
            }
        } else {
            echo "<script>alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF');</script>";
        }
    } else {
        echo "<script>alert('Silakan upload foto profil');</script>";
    }

    // Check if email already exists
    $query_check = "SELECT id FROM tb_users WHERE email = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('Maaf, email sudah terdaftar');</script>";
        echo '<meta http-equiv="refresh" content="1;  >';
        exit();
    }
    $stmt_check->close();

    // Insert data
    $query_insert = "INSERT INTO tb_users (fullname, email, password, jenis_kelamin, no_telp, alamat, image, role_id, created_at, update_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("sssisssiss", $fullname, $email, $password, $jenis_kelamin, $no_telp, $alamat, $image, $role_id, $created_at, $update_at);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login');</script>";
        echo '<meta http-equiv="refresh" content="1; url=?page=login">';
    } else {
        error_log("Database error: " . $stmt_insert->error);
        echo "<script>alert('Terjadi kesalahan saat mendaftar. Silakan coba lagi.');</script>";
    }

    $stmt_insert->close();
    $conn->close();
}
?>
<head>
  <link rel="stylesheet" href="././css/style.css">
</head>
<body style="background-color: beige;">
  <!--Login-->
  <div class="container-fluid vh-90" style="margin-top: 1rem;">
      <div class="row h-100">
          <!-- Kolom Kiri: Logo -->
          <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center bg-transparent">
              <img src="./img/chatbot.png" alt="Logo" class="img-fluid" style="max-width: 30%; margin-bottom: 20px;">
              <h1 class="text-center">Robotors</h1>
          </div>
  
          <!-- Kolom Kanan: Form Login/Register -->
          <div class="col-lg-4 d-flex align-items-center justify-content-center">
              <main class="form-signin w-75">
                   <form method="POST" enctype="multipart/form-data"> <!-- Added enctype -->
                      <h1 class="h3 mb-3 fw-normal text-center">Register</h1>

                      <div class="form-floating">
                      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                      <label for="floatingInput">Email</label>
                      </div>
                      <div class="form-floating mt-1">
                          <input type="text" name="fullname" class="form-control" id="floatingInput" placeholder="name@example.com" required>
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
                      <div class="form-floating mt-1">
                          <input type="file" name="image" class="form-control" id="floatingImage" accept="image/*" required>
                          <label for="floatingImage">Upload Foto Profil</label>
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
