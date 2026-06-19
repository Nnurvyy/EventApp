<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran Acara</title>
</head>
<body style="margin: 0; padding: 40px 20px; background-color: #f8fafc; font-family: 'Quicksand', 'Nunito', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; background-color: #ffffff; border: 3px solid #1e293b; border-radius: 24px; box-shadow: 6px 6px 0px 0px #1e293b; overflow: hidden; border-collapse: separate;">
        <!-- Header Section -->
        <tr>
            <td style="background-color: #e2fbf0; padding: 30px; text-align: center; border-bottom: 3px solid #1e293b;">
                <div style="font-size: 50px; margin-bottom: 10px;">🎉</div>
                <h1 style="margin: 0; font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: -0.02em;">Pendaftaran Berhasil!</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px; font-weight: 600; color: #475569;">Detail pendaftaran acara Anda di bawah ini.</p>
            </td>
        </tr>

        <!-- Body Section -->
        <tr>
            <td style="padding: 30px; background-color: #ffffff;">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; font-weight: 700; color: #1e293b;">Halo, {{ $userName }}! ✨</h2>
                
                <p style="font-size: 14px; color: #475569; line-height: 1.6; margin-top: 0; margin-bottom: 25px;">
                    Pendaftaran Anda untuk mengikuti acara telah berhasil diverifikasi oleh sistem kami. Berikut adalah rincian acara yang akan Anda ikuti:
                </p>

                <!-- Details Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; border: 2px solid #1e293b; border-radius: 16px; margin-bottom: 25px; box-shadow: 3px 3px 0px 0px #1e293b; border-collapse: separate;">
                    <tr>
                        <td style="padding: 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="35%" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; padding-bottom: 10px; font-family: inherit;">Nama Acara</td>
                                    <td width="65%" style="font-size: 15px; font-weight: 800; color: #1e293b; padding-bottom: 10px; font-family: inherit;">{{ $eventTitle }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: inherit;">Tanggal Event</td>
                                    <td style="font-size: 15px; font-weight: 700; color: #0d9488; font-family: inherit;">📅 {{ \Carbon\Carbon::parse($eventDate)->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Note Section -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fef9c3; border: 2px solid #1e293b; border-radius: 16px; box-shadow: 3px 3px 0px 0px #1e293b; margin-bottom: 25px; border-collapse: separate;">
                    <tr>
                        <td style="padding: 15px 20px; font-size: 13px; font-weight: 700; color: #713f12; text-align: center; font-family: inherit;">
                            💡 Terima kasih telah mendaftar event ini.
                        </td>
                    </tr>
                </table>

                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 0; text-align: center;">
                    Silakan simpan email ini sebagai konfirmasi resmi Anda. Sampai jumpa di acara! 🚀
                </p>
            </td>
        </tr>

        <!-- Footer Section -->
        <tr>
            <td style="padding: 20px; background-color: #f8fafc; border-top: 3px solid #1e293b; text-align: center;">
                <p style="margin: 0; font-size: 12px; font-weight: 600; color: #94a3b8; font-family: inherit;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
