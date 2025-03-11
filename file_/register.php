<?php include '_parcials/_template/header.php';
include 'koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role_id = 2;
    $create_at = date('Y-m-d H:i:s');

    $query_check = "SELECT * FROM tb_users WHERE email = ?";
    $stmt_check = $connect->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Email mu sudah terdaftar');</script>";
    } else {
        // Query untuk insert data
        $query_insert = "INSERT INTO tb_users (fullname,email,password,jenis_kelamin,no_telp,alamat,role_id,create_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connect->prepare($query_insert);
        $stmt_insert->bind_param("ssssssss",$fullname,$email,$password,$jenis_kelamin,$no_telp,$alamat,$role_id,$create_at);

        if ($stmt_insert->execute()) {
            header("Location: index.php?page=login"); 
            echo "<script>alert('Akun Berhasil dibuat');</script>";
        } else {
            echo "<script>alert('gagal, Cak ulangi');</script>";
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $connect->close();
}
?>
<head>
    <link rel="stylesheet" href="././css/style.css">
</head>
<body style="background-color: beige;" >



    <div class="container-fluid vh-90 " style="margin-top: 5rem;">
        <div class="row h-100" >
            <!-- Kolom Kiri: Logo -->
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center bg-transparent">
                <img src="./img/chatbot.png" alt="Logo" class="img-fluid" style="max-width: 30%; margin-bottom: 20px;">
                <h1 class="text-center">Robotors</h1>
            </div>

            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <!-- <main class="form-signin w-75" >
                    <form >
                        <h1 class="h3 mb-3 fw-normal text-center">Register</h1>
                        <div class="form-floating">
                            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="floatingInput" name="fullname" placeholder="name@example.com">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="maleCheckbox" name="jenis_kelamin" value="L">
                                <label class="form-check-label" for="maleCheckbox">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="femaleCheckbox" name="jenis_kelamin" value="P">
                                <label class="form-check-label" for="femaleCheckbox">Perempuan</label>
                            </div>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="number" class="form-control" id="floatingInput" name="No_Handphone" placeholder="name@example.com">
                            <label for="floatingInput">No Heandphone</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="floatingInput" name="alamat" placeholder="name@example.com">
                            <label for="floatingInput">Alamat</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
    
                        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Register</button>
                        
                        <div class="text-center mt-3">
                            Sudah memiliki akun? <a href="?page=login">Login</a> 
                        </div>
                    </form>
                </main> -->
                <main class="form-signin w-75">
                    <form method="POST">
                        <h1 class="h3 mb-3 fw-normal text-center">Register</h1>

                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Username" required>
                            <label for="fullname">Username</label>
                        </div>

                        <div class="mt-2">
                            <div class="form-floating">
                                <select class="form-select" id="jenisKelamin" name="jenis_kelamin" required>
                                    <option selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="tel" class="form-control" id="no_telp" name="no_telp" placeholder="No_Handphone" required>
                            <label for="no_telp">No Handphone</label>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>
                            <label for="alamat">Alamat</label>
                        </div>

                        <div class="form-floating mt-2">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
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