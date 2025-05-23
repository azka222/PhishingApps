<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Akun Anda Telah Dibuat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f0f2f5; padding: 20px; margin: 0;">

  <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    
    <h2 style="color: #2c3e50; margin-bottom: 20px;">Halo {{ $name }},</h2>

    <p style="margin-bottom: 16px;">Selamat! Akun Anda telah berhasil dibuat. Berikut informasi login sementara Anda:</p>

    <table style="width: 100%; margin-bottom: 20px;">
      <tr>
        <td style="padding: 8px 0;"><strong>Email:</strong></td>
        <td style="padding: 8px 0;">{{ $email }}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0;"><strong>Password:</strong></td>
        <td style="padding: 8px 0;">{{ $password }}</td>
      </tr>
    </table>

    <p style="margin-bottom: 20px;">Silakan login menggunakan informasi di atas. Demi keamanan, segera ganti password Anda setelah login pertama kali.</p>

    <div style="text-align: center; margin: 30px 0;">
      <a href="https://fischsim.xyz/login" style="display: inline-block; background-color: #1d4ed8; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold;">
        Login Sekarang
      </a>
    </div>

    <p style="font-size: 14px; color: #555;">Jika Anda tidak merasa mendaftar akun ini, abaikan email ini atau hubungi administrator.</p>

    <br>

    <p style="margin-bottom: 0;">Salam,</p>
    <p style="font-weight: bold; margin-top: 0;">Tim Support FischSim</p>
  </div>

</body>
</html>
