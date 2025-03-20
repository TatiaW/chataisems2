<?php
if (!class_exists('ProfilController')) {
    class ProfilController {
        private $connect;

        public function __construct($dbConnection) {
            $this->connect = $dbConnection;
        }

        public function getProfil() {
            if (!isset($_SESSION['user_id'])) {
                return null;
            }
            $user_id = $_SESSION['user_id'];
            $stmt = $this->connect->prepare("SELECT fullname, email, jenis_kelamin, no_telp, alamat, image FROM tb_users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            if ($user) {
                $user['prefix'] = ($user['jenis_kelamin'] == "L") ? "Laki - Laki" : "Janda";
            }        
            return $user ?: [];
        }

        public function uploadProfile() {
            $uploadDir = 'upload/image/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $upload_error = null;
            $image = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $fileName = uniqid() . '-' . basename($file['name']);
                $targetFile = $uploadDir . $fileName;
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($fileType, $allowedTypes)) {
                    $upload_error = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
                } elseif ($file['size'] > 5000000) {
                    $upload_error = "File terlalu besar. Ukuran maksimum 5MB.";
                } else {
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        $user_id = $_SESSION['user_id'];

                        // Hapus gambar lama jika ada
                        $stmt = $this->connect->prepare("SELECT image FROM tb_users WHERE id = ?");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $stmt->bind_result($old_image);
                        $stmt->fetch();
                        $stmt->close();

                        if (!empty($old_image) && file_exists($uploadDir . $old_image)) {
                            unlink($uploadDir . $old_image);
                        }

                        // Simpan gambar baru di database
                        $stmt = $this->connect->prepare("UPDATE tb_users SET image = ? WHERE id = ?");
                        $stmt->bind_param("si", $fileName, $user_id);
                        if ($stmt->execute()) {
                            header ("Location: ?page=account");
                            $image = $fileName;
                            exit();
                        } else {
                            header ("Location: ?page=account");
                            $upload_error = "Gagal menyimpan gambar ke database.";
                        }
                        $stmt->close();
                    } else {
                        $upload_error = "Gagal mengunggah gambar.";
                    }
                }
            }

            return [
                'image' => $image,
                'upload_error' => $upload_error
            ];
        }

        public function updateProfile() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $name = trim($_POST['fullname']);
                $email = trim($_POST['email']);
                $phone = trim($_POST['no_telp']);
                $address = trim($_POST['alamat']);

                $stmt = $this->connect->prepare("UPDATE tb_users SET fullname = ?, email = ?, no_telp = ?, alamat = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Profil berhasil diperbarui!";
                    header("Location: ?page=account");
                    exit;
                } else {
                    $_SESSION['error'] = "Gagal memperbarui profil.";
                    header("Location: ?page=account");
                    exit;
                }
            }
        }
    }
}

?>