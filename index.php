<?php

session_start();
include_once './config/db.php';
include_once './controllers/ProfilController.php';

$page = isset($_GET['page']) ? $_GET['page'] : "home";

function loadPage($page, $connect) {
    $public_pages = ['home', 'login', 'register'];
    
    if (!isset($_SESSION['user_id']) && !in_array($page, $public_pages)) {
        header("Location: index.php?page=home");
        exit();
    }

    switch ($page) {
        case 'home':
            include 'file_/home.php';
            break;
        
        case 'login':
            include 'file_/login.php';
            break;

        case 'register':
            include 'file_/register.php';
            break;

        case 'admin_dashboard':
            include 'file_/vidio.php';
            break;

        case 'account':
            include 'file_/profil.php';
            break;

        case 'welcome':
            include 'file_/welcome.php';
            break;

        case 'logout':
            session_destroy();
            header("Location: index.php?page=home");
            exit();

        case 'maintenance':
            include 'file_/404/maintenance.php';
            break;

        case 'meeting':
            include 'file_/meeting.php';
            break;

        case 'chatai':
            include 'file_/ai.php';
            break;

        case 'update_profile':
            $profilController = new ProfilController($connect);
            $profilController->updateProfile();
            header("Location: index.php?page=account");
            exit();

        default:
            include 'file_/404/error.php';
            break;
    }
}

loadPage($page, $connect);
?>