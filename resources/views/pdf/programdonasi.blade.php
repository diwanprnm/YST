

    @php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Atur margin dan padding sel menjadi 0 */
        .table td {
            margin: 0;
            /* Ubah jumlah sesuai kebutuhan */
            font-size: 8px; /* Ubah ukuran font sesuai kebutuhan */
            font-family: 'Roboto', sans-serif; /* Gunakan font Roboto */
        }
        .table th {
            font-size: 8px; /* Ubah ukuran font sesuai kebutuhan */
            width: 15%;
            font-family: 'Roboto', sans-serif; /* Gunakan font Roboto */
        }
        h1 {
            font-size: 11px; /* Ubah ukuran font sesuai kebutuhan */
            height: 20px; /* Ubah tinggi sel sesuai kebutuhan */
            font-family: 'Roboto', sans-serif; /* Gunakan font Roboto */
            border-bottom: 1px solid #ddd; /* Tambahkan garis bawah */
            margin right:10px;
            
        }
        h6 {
            font-size: 10px; /* Ubah ukuran font sesuai kebutuhan */
            text-align: center; /* Perataan teks ke tengah horizontal */
            vertical-align: middle; /* Perataan teks ke tengah vertikal */
            height: 30px; /* Ubah tinggi sel sesuai kebutuhan */
            font-family: 'Roboto', sans-serif; /* Gunakan font Roboto */
            margin-top: 30px;
        }
        /* Atur margin dan padding tabel menjadi 0 */
        .footer {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            border-top: 1px solid #ddd;
            font-size: 11px;
        }
        .content {
            margin-bottom: 10px; /* Menambahkan margin bawah untuk memberi ruang pada footer */
        }
        .left-align {
            text-align: left;
            font-size: 8px;
            height :10px;
        }
    </style>

    @php
        $namaBulan = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
            );
    @endphp
</head>
   <div class="left-align">
   <span style="float: right;">{{ date('d', strtotime(now())) . ' ' . $namaBulan[date('F', strtotime(now()))] . ' ' . date('Y', strtotime(now())) }}</span>
    <h1>Yayasan Sekar Telkom</h1>
</div>
    <h6>Laporan Program Donasi</h6>
    <div class="container"> 
        <div class="content">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Program</th>
                        <th>Nama Program Donasi</th>
                        <th>Dana Terkumpul</th>
                        <th>Tanggal Penyaluran</th>
                        <th>Penerima Donasi</th>
                        <th>Penanggung Jawab </th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($donasi as $donasiItem)
                        <tr>
                            <td>{{ $donasiItem->id_program_donasi }}</td>
                            <td>{{ $donasiItem->nama_program_donasi }}</td>
                            <td>{{ 'Rp ' . number_format($donasiItem->total_nominal_donasi, 0, ',', '.') }}</td>
                            <td>{{ $donasiItem->tgl_penyaluran ? date('d', strtotime($donasiItem->tgl_penyaluran)) . ' ' . $namaBulan[date('F', strtotime($donasiItem->tgl_penyaluran))] . ' ' . date('Y', strtotime($donasiItem->tgl_penyaluran)) : '-' }}</td>
                            <td>{{ $donasiItem->penerima_donasi }}</td>
                            <td>{{ $donasiItem->penanggung_jawab }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer">
        <strong>&copy; YST 2021.</strong> Yayasan Sekar Telkom
    </div>
</html>
