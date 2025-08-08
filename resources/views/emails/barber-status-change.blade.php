<!DOCTYPE html>
<html>

<head>
    <title>Perubahan Status Barber - {{ config('app.name') }}</title>
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

        .content {
            padding: 30px;
        }

        .content p {
            margin: 0 0 15px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .details-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }

        .details-table td:first-child {
            width: 40%;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            color: white;
        }

        .status-active {
            background-color: #4CAF50;
            /* Hijau untuk aktif */
        }

        .status-inactive {
            background-color: #9E9E9E;
            /* Abu-abu untuk tidak aktif */
        }

        .status-verified {
            background-color: #2196F3;
            /* Biru untuk diverifikasi */
        }

        .status-unverified {
            background-color: #FF9800;
            /* Oranye untuk belum diverifikasi */
        }

        .footer {
            background-color: #f1f1f1;
            padding: 15px 20px;
            text-align: center;
            font-size: 0.85em;
            color: #666;
            border-top: 1px solid #ddd;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header" style="text-align: center;">
            <h1>{{ config('app.name') }}</h1>
            <p>Notifikasi Perubahan Status Barber</p>
        </div>
        <div class="content">
            <p class="greeting"><strong>Halo, {{ $barber->nama_pemilik }}!</strong></p>

            <p>Status akun barbershop Anda di <strong>{{ config('app.name') }}</strong> telah diperbarui.</p>

            <h3 style="color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 10px;">Detail Perubahan</h3>
            <table class="details-table">
                <tr>
                    <td>Status yang Diubah</td>
                    <td>
                        @if ($statusField === 'is_active')
                            Status Aktivasi
                        @elseif($statusField === 'is_verified')
                            Status Verifikasi
                        @else
                            {{ ucfirst(str_replace('_', ' ', $statusField)) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Nilai Baru</td>
                    <td>
                        @if ($statusField === 'is_active')
                            @if ($newValue)
                                <span class="status-badge status-active">Aktif</span>
                            @else
                                <span class="status-badge status-inactive">Tidak Aktif</span>
                            @endif
                        @elseif($statusField === 'is_verified')
                            @if ($newValue)
                                <span class="status-badge status-verified">Terverifikasi</span>
                            @else
                                <span class="status-badge status-unverified">Belum Diverifikasi</span>
                            @endif
                        @else
                            {{ $newValue ? 'Aktif' : 'Tidak Aktif' }}
                        @endif
                    </td>
                </tr>
            </table>

            <h3 style="color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 10px;">Informasi Barber</h3>
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
            </table>

            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi admin.</p>
            <p>Terima kasih telah menggunakan layanan kami.</p>
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
    # Perubahan Status Barber

    Halo {{ $barber->nama_pemilik }},

    Status akun barbershop Anda di **{{ config('app.name') }}** telah diperbarui.

    **Detail Perubahan:**
    - **Status yang Diubah:** {{ ucfirst(str_replace('_', ' ', $statusField)) }}
    - **Nilai Baru:** {{ $newValue ? 'Aktif' : 'Tidak Aktif' }}

    **Detail Barber:**
    - **Nama:** {{ $barber->nama }}
    - **Nama Pemilik:** {{ $barber->nama_pemilik }}
    - **Alamat:** {{ $barber->alamat }}
    - **Telepon:** {{ $barber->telepon }}
    - **Email:** {{ $barber->email }}

    Anda dapat login ke dashboard barber untuk melihat perubahan lebih lanjut.

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent --}}
