
<?php
$page = isset($_GET['page']) ? $_GET['page'] :"home";

function loadPage($page){
    if ($page === 'home'){
      include 'file_/home.php';
    }else if ($page === 'login'){
      include 'file_/login.php';
    }else {
      include 'file_/404/error.php';
    }
}
  


loadPage(page: $page);?>