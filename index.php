<?php
session_start();

function generate_fake_ip() {
    return rand(1,255) . "." . rand(0,255) . "." . rand(0,255) . "." . rand(1,255);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_num = trim($_POST['phone']);
    $refer_code = trim($_POST['refer']) ?: "T5AGUFHW";

    $_SESSION['phone'] = $phone_num;
    $_SESSION['refer'] = $refer_code;

    $url = "https://vapi530c349999t.kulxsqojuz.com/slotuser/login/phone_verify";

    $headers = [
        "Content-Type: application/json;charset=utf-8",
        "Language: en",
        "Tenant-Id: 530",
        "Origin: https://q345vip.com",
        "Referer: https://q345vip.com/",
        "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0",
        "X-Forwarded-For: " . generate_fake_ip()
    ];

    $payload = json_encode([
        "phone_num" => $phone_num,
        "app_id" => "5301"
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    $_SESSION['otp_response'] = $response;
    header("Location: verify.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Referral Bypass – q345vip.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container {
    background: white;
    padding: 25px;
    border-radius: 15px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    text-align: center;
}
h2 {
    margin-bottom: 15px;
    color: #2E7D32;
}
input, button {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
}
button {
    background: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background: #43A047;
}
</style>
</head>
<body>
<div class="container">
<h2>Referral Bypass – q345vip.com</h2>
<form method="POST">
    <input type="text" name="phone" placeholder="Enter Phone Number" required>
    <input type="text" name="refer" placeholder="Referral Code" required>
    <button type="submit">Send OTP</button>
</form>
</div>
</body>
</html>
