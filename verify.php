<?php
session_start();

function generate_fake_ip() {
    return rand(1,255) . "." . rand(0,255) . "." . rand(0,255) . "." . rand(1,255);
}

function generate_fake_device_id() {
    return rand(1000000000000, 9999999999999) . "." . rand(10,99);
}

function generate_password($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pass = '';
    for ($i = 0; $i < $length; $i++) {
        $pass .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $pass;
}

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_code = trim($_POST['otp']);
    $phone_num = $_SESSION['phone'];
    $refer_code = $_SESSION['refer'];
    $password = generate_password();

    $url = "https://vapi530c349999t.kulxsqojuz.com/slotuser/login/pwd_reg";

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
        "password" => $password,
        "app_id" => "5301",
        "channel_code" => "",
        "device_id" => generate_fake_device_id(),
        "region" => "IN",
        "af_id" => "",
        "invite_type" => "2",
        "gps_adid" => "",
        "invite_code" => $refer_code,
        "fbp" => null,
        "fbc" => null,
        "user_agent" => $headers[5],
        "verify_code" => $otp_code
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['success']) && $data['success'] == true) {
        $message = "🎉 OTP Verified Successfully! Redirecting...";
        $success = true;
        echo "<script>setTimeout(function(){ window.location.href='https://t.me/primescripter'; }, 4000);</script>";
    } else {
        $message = "❌ Registration Failed: " . ($data['msg'] ?? 'Unknown Error');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Verify OTP – q345vip.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #2196F3, #1565C0);
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
    color: #1565C0;
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
    background: #2196F3;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background: #1976D2;
}
.message {
    margin-top: 15px;
    font-size: 16px;
}
.success {
    color: green;
}
.error {
    color: red;
}
</style>
</head>
<body>
<div class="container">
<h2>Verify OTP – q345vip.com</h2>
<form method="POST">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit">Verify & Register</button>
</form>
<?php if ($message): ?>
    <div class="message <?php echo $success ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>
</div>
</body>
</html>
