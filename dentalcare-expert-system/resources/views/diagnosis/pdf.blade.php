<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Medis - {{ $diagnosis->user->name }}</title>
    <style>
        /* Reset & Base */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font resmi surat */
            font-size: 12pt;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat (Header) */
        .header-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px double #000; /* Garis ganda khas kop surat */
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .logo-placeholder {
            font-size: 40px;
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
            line-height: 1;
        }
        .clinic-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            color: #2c3e50;
        }
        .clinic-address {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Informasi Pasien */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info-label {
            width: 140px;
            font-weight: bold;
        }
        .info-colon {
            width: 20px;
            text-align: center;
        }

        /* Kotak Hasil Diagnosa */
        .diagnosis-box {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .diagnosis-main {
            font-size: 16pt;
            font-weight: bold;
            color: #c0392b; /* Merah untuk nama penyakit */
            margin-bottom: 5px;
            display: block;
        }
        .confidence-level {
            font-size: 10pt;
            font-style: italic;
            color: #555;
        }

        /* Section Content */
        .section-header {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            display: inline-block;
            padding-bottom: 2px;
        }
        .content-text {
            text-align: justify;
            margin-bottom: 10px;
        }

        /* Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .date-signed {
            margin-bottom: 60px; /* Ruang untuk tanda tangan */
        }
        .doctor-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Footer / Disclaimer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        
        .badge-emergency {
            background-color: #c0392b;
            color: white;
            padding: 2px 8px;
            font-size: 8pt;
            border-radius: 3px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center;">
                <div class="logo-placeholder">🦷</div>
            </td>
            <td width="85%" style="text-align: center;">
                <h1 class="clinic-name">DENTAL CARE EXPERT SYSTEM</h1>
                <p class="clinic-address">Telp: (021) 555-7788 | Email: support@dentalcare.com</p>
                <p class="clinic-address" style="font-style: italic;">"Solusi Cerdas Kesehatan Gigi & Mulut Anda"</p>
            </td>
        </tr>
    </table>

    <div class="doc-title">HASIL PEMERIKSAAN DIGITAL</div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Pasien</td>
            <td class="info-colon">:</td>
            <td><strong>{{ $diagnosis->user->name }}</strong></td>
            
            <td class="info-label">ID Rekam Medis</td>
            <td class="info-colon">:</td>
            <td>#{{ str_pad($diagnosis->id, 6, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="info-label">Usia / Gender</td>
            <td class="info-colon">:</td>
            <td>{{ $diagnosis->user->age ?? '-' }} Tahun / {{ $diagnosis->user->gender == 'male' ? 'Laki-laki' : ($diagnosis->user->gender == 'female' ? 'Perempuan' : '-') }}</td>

            <td class="info-label">Tanggal Periksa</td>
            <td class="info-colon">:</td>
            <td>{{ $diagnosis->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

    <hr style="border: 0; border-top: 1px solid #000; margin-bottom: 20px;">

    <div style="margin-bottom: 10px; font-weight: bold;">HASIL ANALISA SISTEM:</div>
    <div class="diagnosis-box">
        <span class="diagnosis-main">
            {{ $diagnosis->disease_name }}
            @if($diagnosis->is_emergency)
                <span class="badge-emergency">URGENT / DARURAT</span>
            @endif
        </span>
        <div class="confidence-level">
            Tingkat Kecocokan Gejala: {{ $diagnosis->confidence_level }}% 
            (Berdasarkan {{ $diagnosis->matched_symptoms_count }} gejala yang dilaporkan)
        </div>
    </div>

    @if($diagnosis->disease_description)
        <div class="section-header">Deskripsi Medis</div>
        <div class="content-text">
            {{ $diagnosis->disease_description }}
        </div>
    @endif

    @if($diagnosis->recommendation)
        <div class="section-header">Rekomendasi Tindakan</div>
        <div class="content-text">
            {{ $diagnosis->recommendation }}
        </div>
    @endif

    @if($diagnosis->treatment)
        <div class="section-header">Saran Perawatan / Pengobatan Awal</div>
        <div class="content-text">
            {{ $diagnosis->treatment }}
        </div>
    @endif

    @if($diagnosis->prevention)
        <div class="section-header">Edukasi Pencegahan</div>
        <div class="content-text">
            {{ $diagnosis->prevention }}
        </div>
    @endif

    <div class="signature-container">
        <div class="signature-box">
            <div class="date-signed">
                Pekalongan, {{ now()->translatedFormat('d F Y') }}
            </div>
            <div style="margin-bottom: 10px; color: #aaa; font-size: 10pt;">
                [ Ditandatangani Secara Digital ]
            </div>
            <div class="doctor-name">Admin / Sistem Pakar</div>
            <div style="font-size: 10pt;">SIP: DENTAL-AI-2024</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        <p>
            <strong>DISCLAIMER:</strong> Dokumen ini adalah hasil diagnosa awal berdasarkan algoritma sistem pakar.<br>
            Tidak menggantikan konsultasi tatap muka dengan dokter gigi profesional. Jika gejala berlanjut, segera hubungi dokter.
        </p>
    </div>

</body>
</html>