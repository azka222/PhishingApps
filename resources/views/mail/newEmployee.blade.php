<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Akun Anda Telah Dibuat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f0f2f5; padding: 20px; margin: 0;">

  <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    
    <h2 style="color: #2c3e50; margin-bottom: 20px;">Halo {{ $name }},</h2>

    <p style="margin-bottom: 16px;">
      Akun Anda telah dibuat oleh administrator perusahaan untuk memberikan akses ke aplikasi kami.  
      Akun ini diperlukan agar Anda dapat mengakses dan menyelesaikan course yang telah ditugaskan kepada Anda.
    </p>

    <p style="margin-bottom: 16px;">
      Berikut adalah informasi login sementara Anda:
    </p>

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

    <p style="margin-bottom: 20px;">
      Silakan login menggunakan informasi di atas. Demi keamanan, kami sarankan Anda segera mengganti password setelah login pertama kali.
    </p>

    <div style="text-align: center; margin: 30px 0;">
      <a href="https://fischsim.xyz/login" style="display: inline-block; background-color: #1d4ed8; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold;">
        Login Sekarang
      </a>
    </div>

    <br>

    <p style="margin-bottom: 0;">Salam,</p>
    <p style="font-weight: bold; margin-top: 0;">Tim Support FischSim</p>
  </div>

</body>
</html>
