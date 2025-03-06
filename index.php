
<?php

session_start();

$page = isset($_GET['page']) ? $_GET['page'] :"home";
function loadPage($page){
    if ($page === 'home'){
      // if (!isset($_SESSION['user_id'])) {
      //   include 'file_/home.php';
      //   exit();
      // }
      include 'file_/home.php';
      // header("Location: index.php?page=welcome");
    }else if ($page === 'login'){
      include 'file_/login.php';
    }else if ($page === 'register'){
      include 'file_/register.php';
    }else if ($page === 'vidio'){
      include 'file_/vidio.php';
    }else if ($page == 'welcome'){
      if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?page=login");
        exit();
      }
      include 'file_/welcome.php';
    }else {
      include 'file_/404/error.php';
    }
}



loadPage($page);?>