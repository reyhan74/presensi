<?php

namespace App\Models;

use App\Models\PresensiInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use App\Libraries\enums\Kehadiran;

class PresensiGuruModel extends Model implements PresensiInterface
{
   protected $primaryKey = 'id_presensi';

   protected $allowedFields = [
      'id_guru',
      'tanggal',
      'jam_masuk',
      'jam_keluar',
      'id_kehadiran',
      'keterangan'
   ];

   protected $table = 'tb_presensi_guru';

   public function cekAbsen(string|int $id, string|Time $date)
   {
      $result = $this->where(['id_guru' => $id, 'tanggal' => $date])->first();

      if (empty($result)) return false;

      return $result[$this->primaryKey];
   }

   public function absenMasuk(string $id, $date, $time)
   {
      $this->save([
         'id_guru' => $id,
         'tanggal' => $date,
         'jam_masuk' => $time,
         // 'jam_keluar' => '',
         'id_kehadiran' => Kehadiran::Hadir->value,
         'keterangan' => ''
      ]);
   }

   public function absenKeluar(string $id, $time)
   {
      $this->update($id, [
         'jam_keluar' => $time,
         'keterangan' => ''
      ]);
   }

   public function absenIzin(string $idGuru, $tanggal, $jam)
{
   return $this->insert([
      'id_guru'      => $idGuru,
      'tanggal'      => $tanggal,
      'jam_masuk'    => null,
      'jam_keluar'   => null,
      'id_kehadiran' => Kehadiran::Izin->value,
      'keterangan'   => 'Izin',
   ]);
}


   public function getPresensiByIdGuruTanggal($idGuru, $date)
   {
      return $this->where(['id_guru' => $idGuru, 'tanggal' => $date])->first();
   }

   public function getPresensiById(string $idPresensi)
   {
      return $this->where([$this->primaryKey => $idPresensi])->first();
   }

   public function getPresensiByTanggal($tanggal)
   {
      return $this->setTable('tb_guru')
         ->select('*')
         ->join(
            "(SELECT id_presensi, id_guru AS id_guru_presensi, tanggal, jam_masuk, jam_keluar, id_kehadiran, keterangan FROM tb_presensi_guru) tb_presensi_guru",
            "{$this->table}.id_guru = tb_presensi_guru.id_guru_presensi AND tb_presensi_guru.tanggal = '$tanggal'",
            'left'
         )
         ->join(
            'tb_kehadiran',
            'tb_presensi_guru.id_kehadiran = tb_kehadiran.id_kehadiran',
            'left'
         )
         ->orderBy("nama_guru")
         ->findAll();
   }

   public function getPresensiByKehadiran(string $idKehadiran, $tanggal)
   {
      $this->join(
         'tb_guru',
         "tb_presensi_guru.id_guru = tb_guru.id_guru AND tb_presensi_guru.tanggal = '$tanggal'",
         'right'
      );

      if ($idKehadiran == '4') {
         $result = $this->findAll();

         $filteredResult = [];

         foreach ($result as $value) {
            if ($value['id_kehadiran'] != ('1' || '2' || '3')) {
               array_push($filteredResult, $value);
            }
         }

         return $filteredResult;
      } else {
         $this->where(['tb_presensi_guru.id_kehadiran' => $idKehadiran]);
         return $this->findAll();
      }
   }

   public function updatePresensi(
      $idPresensi,
      $idGuru,
      $tanggal,
      $idKehadiran,
      $jamMasuk,
      $jamKeluar,
      $keterangan
   ) {
      $presensi = $this->getPresensiByIdGuruTanggal($idGuru, $tanggal);

      $data = [
         'id_guru' => $idGuru,
         'tanggal' => $tanggal,
         'id_kehadiran' => $idKehadiran,
         'keterangan' => $keterangan ?? $presensi['keterangan'] ?? ''
      ];

      if ($idPresensi != null) {
         $data[$this->primaryKey] = $idPresensi;
      }

      if ($jamMasuk != null) {
         $data['jam_masuk'] = $jamMasuk;
      }

      if ($jamKeluar != null) {
         $data['jam_keluar'] = $jamKeluar;
      }

      return $this->save($data);
   }
}
