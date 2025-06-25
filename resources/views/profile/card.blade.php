<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Profil - {{ $user->name }}</title>
    <style>
        /* Styling font dasar */
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        /* Container utama kartu */
        .card-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 450px; /* Sedikit lebih kecil agar pas */
            margin: auto;
        }

        /* ======================================================= */
        /* ==            PERUBAHAN UTAMA ADA DI SINI            == */
        /* ======================================================= */
        
        /* Header sekarang hanya untuk warna latar */
        .card-header {
            background-color: #4a5568; /* Warna abu-abu gelap */
            height: 80px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* Body kartu sekarang menangani semua konten, termasuk gambar */
        .card-body {
            text-align: center; /* Memusatkan semua konten */
            padding: 0 30px 30px 30px;
        }

        /* Styling baru untuk foto profil */
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            background-color: #e2e8f0;
            /* Trik untuk mengangkat gambar di atas header */
            margin-top: -60px; 
            margin-bottom: 10px;
        }
        
        /* ======================================================= */
        /* ==               AKHIR PERUBAHAN UTAMA               == */
        /* ======================================================= */

        .user-name {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            margin: 0;
        }
        .user-role {
            font-size: 16px;
            color: #718096;
            margin-top: 5px;
            text-transform: capitalize;
        }
        .divider {
            border-top: 1px solid #e2e8f0;
            margin: 20px 0;
        }
        .info-row {
            margin-bottom: 12px;
            text-align: left; /* Kembalikan text-align ke kiri untuk detail */
        }
        .info-label {
            font-size: 12px;
            font-weight: bold;
            color: #a0aec0;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 16px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header">
            {{-- Header ini sekarang hanya sebagai latar belakang berwarna --}}
        </div>
        <div class="card-body">
            {{-- Gambar sekarang menjadi elemen pertama di dalam body --}}
            <img src="{{ $photoPath }}" class="profile-picture" alt="Foto Profil">

            <h1 class="user-name">{{ $user->name }}</h1>
            <p class="user-role">{{ $user->role }}</p>

            <div class="divider"></div>

            {{-- Informasi Umum --}}
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>

            {{-- Informasi Spesifik Peserta --}}
            @if($user->role === 'peserta' && $user->peserta)
                <div class="info-row">
                    <div class="info-label">NISN</div>
                    <div class="info-value">{{ $user->peserta->nisn }}</div>
                </div>
                 <div class="info-row">
                    <div class="info-label">Asal Sekolah / Kampus</div>
                    <div class="info-value">{{ $user->peserta->asal_sekolah }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kelas / Jurusan</div>
                    <div class="info-value">{{ $user->peserta->kelas }} / {{ $user->peserta->jurusan }}</div>
                </div>
            @endif
            
            {{-- Informasi Spesifik Pembimbing --}}
            @if($user->role === 'pembimbing' && $user->pembimbing)
                <div class="info-row">
                    <div class="info-label">NIP</div>
                    <div class="info-value">{{ $user->pembimbing->nip ?? '-' }}</div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>