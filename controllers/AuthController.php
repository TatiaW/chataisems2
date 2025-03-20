<?php
if (!class_exists('AuthController')) {
    class AuthController {
        private $connect;

        public function __construct($dbConnection) {
            $this->connect = $dbConnection;
        }

        public function login($email, $password) {
            $stmt = $this->connect->prepare("SELECT id, fullname, email, password, role_id FROM tb_users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    // $_SESSION['role_id'] = $user['role_id'];
                    // if ($user['role_id'] == 1) {
                    //     header("Location: index.php?page=admin_dashboard");
                    // } else {
                    //     header("Location: index.php?page=home");
                    // }
                    // exit();
                    $_SESSION['success_message'] = "Login Berhasil!  ";

                    header("Location: index.php?page=welcome"); 
                    exit();
                } else {
                    return "Invalid password!";
                }
            } else {
                return "Email not found!";
            }
            $stmt->close();
        }

        public function getCurrentUser() {
            if (!isset($_SESSION['user_id'])) {
                return null;
            }

            $user_id = $_SESSION['user_id'];
            $stmt = $this->connect->prepare("SELECT fullname, email, image FROM tb_users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $stmt->close();
                return $user;
            }
            $stmt->close();
            return null;
        }

        public function getUserData() {
            if (!isset($_SESSION['user_id'])) {
                return null;
            }
            $user_id = $_SESSION['user_id'];
            $stmt = $this->connect->prepare("SELECT fullname, email, jenis_kelamin, image  FROM tb_users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            if ($user) {
                $user['prefix'] = ($user['jenis_kelamin'] == "L") ? "Mr." : "Ms.";
            }        
            return $user ?: [];
        }
    }
}
?>