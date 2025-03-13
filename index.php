
<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] :"home";
function loadPage($page){
    if ($page === 'home'){
      include 'file_/home.php';
    }else if ($page === 'login'){
      include 'file_/login.php';
    }else if ($page === 'logout'){
      include 'file_/logout.php';
    } else if ($page === 'register'){
      include 'file_/register.php';
    }else if ($page === 'about'){
      include 'file_/about.php';
    }else if ($page === 'admin_dashboard' && isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2) {
      include 'file_/admin_dashboard.php'; // Buat file ini
  } else {
      include 'file_/404/error.php';
    }
}
  

include '_parcials/_template/header.php';
loadPage(page: $page);?>