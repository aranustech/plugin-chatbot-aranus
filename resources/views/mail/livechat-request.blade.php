<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Live Chat Baru</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.08); overflow:hidden;">
                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#00A86B,#2BC48A); padding:28px 32px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:20px; font-weight:700; letter-spacing:0.5px;">
                                Permintaan Live Chat Baru
                            </h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px; color:#374151; font-size:15px; line-height:1.6;">
                                Halo Admin,
                            </p>
                            <p style="margin:0 0 24px; color:#374151; font-size:15px; line-height:1.6;">
                                Seorang pengunjung meminta untuk <strong>berbicara langsung dengan admin</strong> melalui fitur Live Chat.
                            </p>

                            {{-- Info Card --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:4px 0; color:#6b7280; font-size:13px; width:120px;">Session ID</td>
                                                <td style="padding:4px 0; color:#111827; font-size:13px; font-weight:600;">{{ $sessionCode }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:4px 0; color:#6b7280; font-size:13px;">Waktu Permintaan</td>
                                                <td style="padding:4px 0; color:#111827; font-size:13px; font-weight:600;">{{ $requestTime }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- CTA Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/'.config('chatbot.prefix', 'dashboard').'/live-chat') }}"
                                           style="display:inline-block; background:#00A86B; color:#ffffff; text-decoration:none; padding:12px 32px; border-radius:8px; font-size:14px; font-weight:600; letter-spacing:0.3px;">
                                            Buka Dashboard Live Chat
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0; color:#9ca3af; font-size:12px; text-align:center; line-height:1.5;">
                                Segera tanggapi permintaan ini agar pengunjung tidak menunggu terlalu lama.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f9fafb; padding:16px 32px; border-top:1px solid #e5e7eb; text-align:center;">
                            <p style="margin:0; color:#9ca3af; font-size:11px;">
                                &copy; {{ date('Y') }} Aranus Chatbot. Email ini dikirim secara otomatis.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
