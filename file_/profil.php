<?php
include '_parcials/_template/header.php';
include_once './controllers/ProfilController.php';

$ProfileController = new ProfilController($connect);

$ProfileData = $ProfileController->getProfil();
$profile_image = $ProfileData['image'];
$userName = $ProfileData['fullname'];
$userEmail = $ProfileData['email'];
$hp = $ProfileData['no_telp'];
$alamat = $ProfileData['alamat'];
$jenis = $ProfileData['jenis_kelamin'];
$show_upload_modal = empty($profile_image);

$profile_image = !empty($profile_image) ? 'upload/image/' . $profile_image : 'img/robot-ai.png';

// Proses upload Profile
$uploadResult = $ProfileController->uploadProfile();
if ($uploadResult['image']) {
    $profile_image = $uploadResult['image'];
    $show_upload_modal = false;
}
$upload_error = $uploadResult['upload_error'];
?>

<style>
/* Style untuk gambar profil */
.profile-img {
    transition: filter 0.3s ease-in-out; /* Efek transisi blur */
}

/* Style untuk ikon edit */
.edit-icon {
    position: absolute;
    bottom: 5px;  
    right: 5px;
    width: 30px;  
    height: 30px;
    color: black;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%; /* Membuat lingkaran sempurna */
    font-size: 20px;
    opacity: 0; /* Sembunyikan ikon awalnya */
    transition: opacity 0.3s ease-in-out;
}


/* Efek saat hover */
.position-relative:hover .profile-img {
    filter: blur(3px); /* Blur gambar */
}

.position-relative:hover .edit-icon {
    opacity: 1; /* Tampilkan ikon edit */
    cursor: pointer;
}
</style>
<main class="container">
    <!-- Tombol Kembali ke Menu Utama -->
    <div class="mt-3">
        <a href="?page=welcome" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <div class="card-body text-center">
                    <!-- <img src="<?php echo htmlspecialchars($profile_image); ?>" class="rounded-circle mb-3" width="120" alt="Foto Profil" 
                    style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#uploadModal">

                    <span class="edit-icon">
                    <i class="bi bi-pencil-fill"></i>
                    </span> -->

                    <div class="position-relative d-inline-block">
                        <!-- Gambar Profil -->
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" 
                            id="profileImage"
                            class="rounded-circle mb-3 profile-img" 
                            width="120" 
                            alt="Foto Profil" 
                            style="cursor: pointer;"
                            data-bs-toggle="modal" 
                            data-bs-target="#uploadModal">
                        
                        <!-- Ikon Edit di dalam gambar -->
                        <span class="edit-icon">
                            <i class="bi bi-pencil-fill"></i>
                        </span>
                    </div>

                    <div class="row text-start">
                        <div class="col-4 fw-bold text-muted">Nama </div>
                        <div class="col-8 text-muted">: <?php echo htmlspecialchars($userName); ?></div>
                    </div>

                    <div class="row text-start mt-2">
                        <div class="col-4 fw-bold text-muted">Email </div>
                        <div class="col-8 text-muted">: <?php echo htmlspecialchars($userEmail); ?></div>
                    </div>

                    <div class="row text-start mt-2">
                        <div class="col-4 fw-bold text-muted">No telp    </div>
                        <div class="col-8 text-muted">: <?php echo htmlspecialchars($hp); ?></div>
                    </div>

                    <div class="row text-start mt-2">
                        <div class="col-4 fw-bold text-muted">Alamat   </div>
                        <div class="col-8 text-muted">: <?php echo htmlspecialchars($alamat); ?></div>
                    </div>

                    <div class="row text-start mt-2">
                        <div class="col-4 fw-bold text-muted">Jenis Kelamin   </div>
                        <div class="col-8 text-muted">: <?php echo $ProfileData['prefix']. " " ; ?></div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color:  #ff8838">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="?page=update_profile">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userName); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telp</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($hp); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?php echo htmlspecialchars($alamat); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="uploadModalLabel">Upload Foto Profil</h5>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-3">
                        <!-- Gambar Preview -->
                        <img id="previewImage" src="<?php echo htmlspecialchars($profile_image); ?>" 
                            alt="Foto Profil" class="rounded-circle" width="120" height="120">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>




</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    <?php if ($show_upload_modal): ?>
        document.addEventListener('DOMContentLoaded', function() {
            var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'), {
                backdrop: 'static',
                keyboard: false
            });
            uploadModal.show();
        });
    <?php endif; ?>

    document.getElementById('image').addEventListener('change', function(event) {
        var file = event.target.files[0]; 
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result; 
            };
            reader.readAsDataURL(file); 
        }
    });
</script>
</body>
</html>



