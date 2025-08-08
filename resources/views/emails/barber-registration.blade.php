<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Pendaftaran Barber Baru</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .content p {
            margin: 0 0 15px 0;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #007bff;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .details-table td:first-child {
            width: 40%;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            background-color: #f1f1f1;
            padding: 15px 20px;
            text-align: center;
            font-size: 0.85em;
            color: #666;
            border-top: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #036ad8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header" style="text-align: center;">
            <h1>{{ config('app.name') }}</h1>
            <p>Notifikasi Pendaftaran Barber Baru</p>
        </div>
        <div class="content">
            <p class="greeting"><strong>Kepada Tim Admin,</strong></p>

            <p>Seorang calon pemilik barber telah mendaftarkan akun barbershop mereka. Mohon untuk diverifikasi dan
                diaktifkan.</p>

            <h3 style="color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 10px;">Detail Barber</h3>
            <table class="details-table">
                <tr>
                    <td>Nama Barber</td>
                    <td>{{ $barber->nama }}</td>
                </tr>
                <tr>
                    <td>Nama Pemilik</td>
                    <td>{{ $barber->nama_pemilik }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>{{ $barber->alamat }}</td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td>{{ $barber->telepon }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $barber->email }}</td>
                </tr>
                <tr>
                    <td>Waktu Buka</td>
                    <td>{{ $barber->waktu_buka }}</td>
                </tr>
                <tr>
                    <td>Waktu Tutup</td>
                    <td>{{ $barber->waktu_tutup }}</td>
                </tr>
                <tr>
                    <td>Maks. Pelanggan/Jam</td>
                    <td>{{ $barber->maksimum_pelanggan_per_jam }}</td>
                </tr>
            </table>

            <p>Silakan login ke sistem admin untuk memproses pendaftaran ini.</p>
            <!-- Ganti URL berikut dengan URL dashboard admin Anda -->
            <a href="{{ url('/admin-komunitas/dashboard') }}" class="btn">Login ke Dashboard Admin</a>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem {{ config('app.name') }}. Mohon tidak membalas email ini.
            </p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

{{-- @component('mail::message')
    # Notifikasi Pendaftaran Barber Baru

    Halo Admin,

    Sebuah akun barber baru telah didaftarkan dengan detail sebagai berikut:

    **Detail Barber:**
    - **Nama:** {{ $barber->nama }}
    - **Nama Pemilik:** {{ $barber->nama_pemilik }}
    - **Alamat:** {{ $barber->alamat }}
    - **Telepon:** {{ $barber->telepon }}
    - **Email:** {{ $barber->email }}

    Silakan login ke dashboard admin untuk memverifikasi dan mengaktifkan akun barber ini.

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent --}}
