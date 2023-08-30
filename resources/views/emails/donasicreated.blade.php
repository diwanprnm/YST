<p>Halo {{ $donasi->nama_donatur }},</p>
<p>Pembuatan Donasi Berhasil Donasi Anda Sebesar {{ 'Rp ' . number_format($donasi->nominal_donasi, 0, ',', '.') }}.</p>
<p>Silakan transfer ke rekening yang tertera di website kami untuk menyelesaikan pembayaran.</p>
<p>Detail donasi:</p>
<ul>
    <li>Nama Donatur:   {{ $donasi->nama_donatur }}</li>
    <li>Nominal Donasi: {{ 'Rp ' . number_format($donasi->belum_dibayar, 0, ',', '.') }}</li>
    <li>Tanggal Donasi: {{ $donasi->tgl_donasi }}</li>
</ul>
<p>Terima kasih atas dukungan Anda!</p>