<style>
    body {
        margin: 20px 30px;
    }
</style>

<html>
<head>
    <title><?= $judul ?></title>
</head>
<body>
    <h1 style="text-align: center">Laporan Pemasukan Keuangan</h1>
    <h3 style="text-align: center">Periode <?= $tanggal_awal ?> - <?= $tanggal_akhir ?></h3>
    <table style="width: 100%; border-collapse: collapse" border="1">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
        <?php $no = 1; foreach($data as $row) : ?>
        <tr>
                <td><?= $no ?></td>
                <td><?= $row->kode ?></td>
                <td><?= $row->nama ?></td>
                <td><?= $row->tanggal ?></td>
                <td>Rp. <?= number_format($row->jumlah, 0, ',', '.') ?></td>
                <td><?= $row->keterangan ?></td>
        </tr>
        <?php $no++; endforeach; ?>
    </table>
</body>
</html>
<script>
    window.print();
</script>