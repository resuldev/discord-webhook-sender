<?php
// Webhook URL'si
$webhook_url = " ";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesaj = $_POST['mesaj'] ?? '';
    $imza = $_POST['imza'] ?? '';

    $mesaj_icerigi = "{$mesaj}\n\n   -{$imza}";

    $data = array(
        "content" => $mesaj_icerigi
    );


    $json_data = json_encode($data);


    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // İsteğin sonucunu kontrol etme
    if ($response === false) {
        echo "Mesaj gönderilirken bir hata oluştu: " . curl_error($ch);
    } else {
        echo "Mesaj başarıyla gönderildi.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Discord Webhook</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            position: relative;
            margin: 0;
            padding-bottom: 40px; /* Coded by ugabuga yazısının yerleşeceği alan için alt boşluk */
            background-color: #333;
            color: #fff;
            font-family: "Segoe UI", Arial, sans-serif;
            letter-spacing: 1px;
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .message-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            max-width: 400px;
            margin-bottom: 20px;
        }

        .message-input {
            padding: 10px;
            border: none;
            background-color: #444;
            color: #fff;
            outline: none;
            transition: background-color 0.3s;
        }

        .message-input:focus {
            background-color: #555;
        }

        .submit-button {
            padding: 10px 20px;
            background-color: #7289DA;
            color: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #5B6F99;
        }

        .submit-button:active {
            background-color: #496382;
        }

        .success-message {
            color: #00FF00;
            font-weight: bold;
        }


        .coded-by {
            position: fixed;
            bottom: 10px;
            right: 10px;
            margin: 10px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="message-form" method="POST">
            <input type="text" name="mesaj" placeholder="Mesajı girin" class="message-input" required>
            <input type="text" name="imza" placeholder="İmza" class="message-input" required>
            <button type="submit" class="submit-button"><i class="fas fa-paper-plane"></i> Gönder</button>
        </form>
        <div class="success-message"></div>
    </div>
    <div class="coded-by"><i class="fas fa-code"></i> Coded by ugabuga</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('.message-form');
            var successMessage = document.querySelector('.success-message');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'webhook.php');
                xhr.onload = function() {
                    if (xhr.status === 204) {
                        successMessage.textContent = "Mesaj başarıyla gönderildi.";
                        form.reset();
                    } else {
                        successMessage.textContent = "Mesaj gönderilirken bir hata oluştu. Hata kodu: " + xhr.status;
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
