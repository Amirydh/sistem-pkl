<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Profil - {{ $user->name }}</title>
    
    <!-- LINK CDN DAN FONT KUSTOM SUDAH DIHAPUS SEMUA -->

    <style>
        /* Variabel Warna Tetap Bisa Digunakan */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #50E3C2;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --background-color: #ecf0f1;
            --card-background: #ffffff;
            --border-color: #dfe6e9;
        }

        /* TIDAK ADA LAGI @font-face */

        body {
            /* 
             * PERUBAHAN UTAMA: Menggunakan font sans-serif bawaan Dompdf (Helvetica).
             * Ini adalah kunci agar PDF berhasil dibuat tanpa error.
            */
            font-family: sans-serif; 
            background-color: var(--background-color);
            color: var(--text-dark);
            margin: 0;
            padding: 20px;
        }

        .card-container {
            display: flex;
            background-color: var(--card-background);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            max-width: 80vh;
            width: 100%;
            margin: auto;
            align-items: center;
            justify-content: center;
            overflow: hidden; 
        }

        .card-header {
            background-color: var(--primary-color); /* Menggunakan warna solid karena gradien kadang berat */
            height: 120px;
        }
        
        .card-body {
            padding: 20px 30px 30px;
            text-align: center;
        }

        .profile-section {
            margin-top: -80px;
        }
        
        .profile-picture {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid var(--card-background);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            background-color: #f0f0f0;
            margin-bottom: 15px;
        }

        .user-name {
            font-size: 26px;
            font-weight: bold; /* Bold bawaan akan berfungsi */
            color: var(--text-dark);
            margin: 0;
        }

        .user-role {
            font-size: 16px;
            color: var(--primary-color);
            margin-top: 4px;
            text-transform: capitalize;
        }

        .divider {
            border: 0;
            height: 1px;
            background-color: var(--border-color);
            margin: 25px 0;
        }

        .info-section {
            text-align: left;
        }
        
        .info-row {
            /* Mengatur ulang layout karena tidak ada ikon lagi */
            margin-bottom: 18px;
        }
        
        .info-label {
            font-size: 14px;
            font-weight: bold;
            color: var(--text-light);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 16px;
            color: var(--text-dark);
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header"></div>
        
        <div class="card-body">
            <div class="profile-section">
                <img src="{{ $photoPath }}" class="profile-picture" alt="Foto Profil">
                <h1 class="user-name">{{ $user->name }}</h1>
            </div>

            <hr class="divider">

            <div class="info-section">
                {{-- Informasi Umum --}}
                <div class="info-row">
                    {{-- IKON DIHAPUS --}}
                    <div class="info-content">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                </div>

                {{-- Informasi Spesifik Peserta --}}
                @if($user->role === 'peserta' && $user->peserta)
                    <div class="info-row">
                        <div class="info-content">
                            <div class="info-label">NISN</div>
                            <div class="info-value">{{ $user->peserta->nisn }}</div>
                        </div>
                    </div>
                     <div class="info-row">
                        <div class="info-content">
                            <div class="info-label">Asal Sekolah / Kampus</div>
                            <div class="info-value">{{ $user->peserta->asal_sekolah }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-content">
                            <div class="info-label">Kelas / Jurusan</div>
                            <div class="info-value">{{ $user->peserta->kelas }} / {{ $user->peserta->jurusan }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-content">
                            <div class="info-label">Ruangan</div>
                            <div class="info-value">
                                @if($user->peserta && $user->peserta->lokasiPkl)
                                    {{ $user->peserta->lokasiPkl->nama_tempat }}<br>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Informasi Spesifik Pembimbing --}}
                @if($user->role === 'pembimbing' && $user->pembimbing)
                    <div class="info-row">
                        <div class="info-content">
                            <div class="info-label">NIP</div>
                            <div class="info-value">{{ $user->pembimbing->nip ?? '-' }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>