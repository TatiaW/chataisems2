<?php
include '_parcials/_template/header.php';
?>
<main>
<body>
    <div class="container-fluid chat-container">
        <!-- Sidebar teman -->
        <div class="friends-list p-3">
            <h5>Teman</h5>
            <ul class="list-group" id="friend-list">
                <?php
                // Ambil daftar teman dari database
                // $conn = new mysqli("localhost", "root", "", "chat_db");
                // $result = $conn->query("SELECT id, nama FROM teman");
                // while ($row = $result->fetch_assoc()) {
                //     echo '<li class="list-group-item friend" data-id="'.$row['id'].'">'.$row['nama'].'</li>';
                // }
                ?>
            </ul>
        </div>
        
        <!-- Kotak Chat -->
        <div class="chat-box p-3">
            <h5 id="chat-header">Pilih teman untuk mulai chat</h5>
            <div class="chat-messages" id="chat-messages"></div>
            
            <!-- Input Pesan -->
            <div class="input-group">
                <input type="text" class="form-control" id="message-input" placeholder="Ketik pesan...">
                <button class="btn btn-primary" id="send-btn">Kirim</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let selectedFriendId = null;
            
            // Pilih teman dan load chat
            $(document).on("click", ".friend", function() {
                selectedFriendId = $(this).data("id");
                $("#chat-header").text("Chat dengan " + $(this).text());
                loadChat();
            });
            
            // Fungsi untuk load chat
            function loadChat() {
                if (selectedFriendId) {
                    $.post("load_chat.php", { friend_id: selectedFriendId }, function(data) {
                        $("#chat-messages").html(data);
                    });
                }
            }
            
            // Kirim pesan
            $("#send-btn").click(function() {
                let message = $("#message-input").val();
                if (message.trim() !== "" && selectedFriendId) {
                    $.post("send_message.php", { friend_id: selectedFriendId, message: message }, function() {
                        loadChat();
                        $("#message-input").val("");
                    });
                }
            });
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</main>

<?php
include '_parcials/_template/footer.php';
?>