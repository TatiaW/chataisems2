<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .video-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-end" >
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="text-with nav-link">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- <nav class="navbar navbar-expand-lg bg-warning " style="border-bottom: 5px solid  #ff8838;">
        <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
            <ul class="navbar-nav me-3 my-2 my-lg-0 navbar-nav-scroll">
            <li class="">
                <a class=" text-white" style="font-size: 20px;">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" style="font-size: 20px;">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false" style="font-size: 20px;">
                Profile
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">API Integrations</a></li>
                <li><a class="dropdown-item" href="#">Embedded AI Chatbots</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Cloud Datasets</a></li>
                </ul>
            </li>
            </ul>
            </div>
        </div>
    </nav> -->
    <div class="container text-center mt-5">
        <h2>INI HANYA UNTUK PENGETESAN</h2>
        <div class="row">
            <div class="col-md-4">
                    <video controls class="w-100">
                        <source src="./video/AQUA_ENGLISH.mp4" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
            </div>
            <div class="col-md-4">
                <video controls class="w-100">
                    <source src="./video/AQUA_ENGLISH.mp4" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
            <div class="col-md-4">
                <video controls class="w-100">
                    <source src="./video/AQUA_ENGLISH.mp4" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
            <div class="col-md-4 offset-md-8"> <!-- Membuat vidio ini ke kanan -->
                <video controls class="w-100">
                    <source src="./video/AQUA_ENGLISH.mp4" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
