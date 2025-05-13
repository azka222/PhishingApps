<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Anda Telah Dibuat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f8f8f8; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <h2 style="color: #333;">Halo {{ $name }},</h2>

        <p>Akun Anda telah berhasil dibuat. Berikut adalah informasi login sementara Anda:</p>

        <ul style="list-style-type: none; padding: 0;">
            <li><strong>Email:</strong> {{ $email }}</li>
            <li><strong>Password:</strong> {{ $password }}</li>
        </ul>

        <p>Silakan login menggunakan informasi di atas. Demi keamanan, segera ganti password Anda setelah login pertama kali.</p>

        <p>Jika Anda tidak merasa mendaftar akun ini, abaikan email ini atau hubungi admin.</p>

        <br>

        <p>Salam,</p>
        <p><strong>Tim Support</strong></p>
    </div>

</body>
</html>
