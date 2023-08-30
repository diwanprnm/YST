<p>Halo {{ $relawan->nama }},</p>
<p>kami telah menyetujui pendaftaran relawan Anda dengan rincian berikut telah diverifikasi:</p>
<ul>
    <li>Nama Relawan: {{ $relawan->nama }}</li>
    <li>Nama Program Relawan: {{ $programRelawanData->nama_program_relawan }}</li>
    <li>Tanggal Pelaksanaan: {{ $programRelawanData->tgl_pelaksanaan }}</li>
    <li>Lokasi Program: {{ $programRelawanData->lokasi_program }}</li>
    <li>Lokasi Awal: {{ $programRelawanData->lokasi_awal }}</li>
</ul>
<p>Terima kasih atas kontribusi Anda sebagai relawan!</p>   