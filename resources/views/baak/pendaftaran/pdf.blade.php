<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pendaftar</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #111;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }
        .badge-menunggu { background-color: #e5e7eb; color: #374151; }
        .badge-ditinjau { background-color: #fef08a; color: #854d0e; }
        .badge-lolos { background-color: #bbf7d0; color: #166534; }
        .badge-ditolak { background-color: #fecaca; color: #991b1b; }
        
        .footer {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Pendaftar Beasiswa UNIKU</h1>
        <p>
            Filter Status: <strong>{{ $filter ?: 'Semua Status' }}</strong><br>
            Tanggal Dicetak: {{ date('d F Y, H:i') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">NIM</th>
                <th width="20%">Nama Pendaftar</th>
                <th width="20%">Program Beasiswa</th>
                <th width="15%">Jurusan</th>

                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $key => $p)
                @php
                    $badgeClass = 'badge-menunggu';
                    if($p->status_verifikasi == 'SEDANG DITINJAU') $badgeClass = 'badge-ditinjau';
                    if($p->status_verifikasi == 'LOLOS') $badgeClass = 'badge-lolos';
                    if($p->status_verifikasi == 'DITOLAK') $badgeClass = 'badge-ditolak';
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $p->nim }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->beasiswa->nama_beasiswa }}</td>
                    <td>{{ $p->jurusan }}</td>

                    <td class="text-center">
                        <span class="badge {{ $badgeClass }}">{{ $p->status_verifikasi }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pendaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Disahkan oleh,</p>
        <br><br><br>
        <p><strong>Administrator Kemahasiswaan</strong></p>
    </div>
</body>
</html>
