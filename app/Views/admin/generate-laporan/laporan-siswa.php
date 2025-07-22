<?= $this->extend('templates/laporan') ?>

<?= $this->section('content') ?>
<style>
   table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-family: Arial, sans-serif;
      font-size: 14px;
   }

   th, td {
      padding: 8px;
      border: 1px solid #444;
   }

   th {
      background-color: #007bff;
      color: white;
      text-align: center;
   }

   .header-table td {
      border: none;
   }

   .school-info h2,
   .school-info h4 {
      margin: 0;
      line-height: 1.4;
   }

   .summary td {
      border: none;
      padding: 4px;
   }
</style>

<table class="header-table">
   <tr>
      <td><img src="<?= getLogo(); ?>" width="100px" height="100px"></td>
      <td class="school-info" width="100%" align="center">
         <h2>DAFTAR HADIR SISWA</h2>
         <h4><?= $generalSettings->school_name; ?></h4>
         <h4>TAHUN PELAJARAN <?= $generalSettings->school_year; ?></h4>
      </td>
      <td><div style="width:100px"></div></td>
   </tr>
</table>

<div style="margin-bottom: 10px;">
   <span><strong>Bulan:</strong> <?= $bulan; ?></span>
   <span style="float: right;"><strong>Kelas:</strong> <?= "{$kelas['kelas']} {$kelas['jurusan']}"; ?></span>
</div>

<table>
   <thead>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th colspan="<?= count($tanggal); ?>">Hari/Tanggal</th>
         <th colspan="4">Total</th>
      </tr>
      <tr>
         <?php foreach ($tanggal as $value) : ?>
            <th><?= $value->toLocalizedString('E'); ?><br><?= $value->format('d'); ?></th>
         <?php endforeach; ?>
         <th style="background-color:lightgreen;">H</th>
         <th style="background-color:yellow;">S</th>
         <th style="background-color:yellow;">I</th>
         <th style="background-color:red;">A</th>
      </tr>
   </thead>
   <tbody>
      <?php $i = 0; ?>
      <?php foreach ($listSiswa as $siswa) : ?>
         <?php
         $jumlahHadir = count(array_filter($listAbsen, fn($a) => !$a['lewat'] && ($a[$i]['id_kehadiran'] ?? 0) == 1));
         $jumlahSakit = count(array_filter($listAbsen, fn($a) => !$a['lewat'] && ($a[$i]['id_kehadiran'] ?? 0) == 2));
         $jumlahIzin = count(array_filter($listAbsen, fn($a) => !$a['lewat'] && ($a[$i]['id_kehadiran'] ?? 0) == 3));
         $jumlahTidakHadir = count(array_filter($listAbsen, fn($a) => !$a['lewat'] && (!isset($a[$i]['id_kehadiran']) || $a[$i]['id_kehadiran'] == 4)));
         ?>
         <tr>
            <td align="center"><?= $i + 1; ?></td>
            <td><?= $siswa['nama_siswa']; ?></td>
            <?php foreach ($listAbsen as $absen) : ?>
               <?= kehadiran($absen[$i]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4)); ?>
            <?php endforeach; ?>
            <td align="center"> <?= $jumlahHadir ?: '-'; ?> </td>
            <td align="center"> <?= $jumlahSakit ?: '-'; ?> </td>
            <td align="center"> <?= $jumlahIzin ?: '-'; ?> </td>
            <td align="center"> <?= $jumlahTidakHadir ?: '-'; ?> </td>
         </tr>
         <?php $i++; ?>
      <?php endforeach; ?>
   </tbody>
</table>

<table class="summary">
   <tr>
      <td><strong>Jumlah siswa</strong></td>
      <td>: <?= count($listSiswa); ?></td>
   </tr>
   <tr>
      <td><strong>Laki-laki</strong></td>
      <td>: <?= $jumlahSiswa['laki']; ?></td>
   </tr>
   <tr>
      <td><strong>Perempuan</strong></td>
      <td>: <?= $jumlahSiswa['perempuan']; ?></td>
   </tr>
</table>

<?php
function kehadiran($kehadiran)
{
   switch ($kehadiran) {
      case 1:
         return "<td align='center' style='background-color:lightgreen;'>H</td>";
      case 2:
         return "<td align='center' style='background-color:yellow;'>S</td>";
      case 3:
         return "<td align='center' style='background-color:yellow;'>I</td>";
      case 4:
         return "<td align='center' style='background-color:red;'>A</td>";
      case 5:
      default:
         return "<td></td>";
   }
}
?>
<?= $this->endSection() ?>
