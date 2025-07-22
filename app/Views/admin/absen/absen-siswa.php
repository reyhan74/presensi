<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="row justify-content-between">
                     <div class="col">
                        <div class="pt-3 pl-3">
                           <h4><b>Daftar Kelas</b></h4>
                           <p>Silakan pilih kelas</p>
                        </div>
                     </div>
                  </div>

                  <!-- Dropdown & Pencarian -->
                  <div class="card-body pt-1 px-3">
                     <div class="row g-3 align-items-end">
                        <!-- Dropdown Kelas -->
                        <div class="col-md-4">
                           <label for="kelasDropdown"><b>Pilih Kelas:</b></label>
                           <select id="kelasDropdown" class="form-select form-control" onchange="onKelasChange()">
                              <option value="" disabled selected>-- Pilih Kelas --</option>
                              <?php foreach ($kelas as $value) : ?>
                                 <?php
                                 $idKelas = $value['id_kelas'];
                                 $namaKelas = $value['kelas'] . ' ' . $value['jurusan'];
                                 ?>
                                 <option value="<?= $idKelas; ?>|<?= $namaKelas; ?>">
                                    <?= $namaKelas; ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- Tanggal -->
                  <div class="row">
                     <div class="col-md-3">
                        <div class="pt-3 pl-3 pb-2">
                           <h4><b>Tanggal</b></h4>
                           <input class="form-control" type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d'); ?>" onchange="onDateChange()">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Data Siswa -->
      <div class="card" id="dataSiswa">
         <div class="card-body">
            <div class="row justify-content-between">
               <div class="col-auto me-auto">
                  <div class="pt-3 pl-3">
                     <h4><b>Absen Siswa</b></h4>
                     <p>Daftar siswa muncul di sini</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal Ubah Kehadiran -->
   <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="modalUbahKehadiran">Ubah kehadiran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div id="modalFormUbahSiswa"></div>
         </div>
      </div>
   </div>
</div>

<!-- SCRIPT -->
<script>
   var lastIdKelas = null;
   var lastKelas = null;

   function onKelasChange() {
      const val = document.getElementById('kelasDropdown').value;
      if (!val) return;

      const [idKelas, namaKelas] = val.split('|');
      getSiswa(idKelas, namaKelas);
   }

   function onDateChange() {
      if (lastIdKelas && lastKelas) {
         getSiswa(lastIdKelas, lastKelas);
      }
   }

   function getSiswa(idKelas, kelas) {
      const tanggal = document.getElementById('tanggal').value;

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-siswa'); ?>",
         type: 'post',
         data: {
            'kelas': kelas,
            'id_kelas': idKelas,
            'tanggal': tanggal
         },
         success: function(response) {
            $('#dataSiswa').html(response);
            $('html, body').animate({
               scrollTop: $("#dataSiswa").offset().top
            }, 500);
         },
         error: function(xhr, status, error) {
            console.log(error);
            $('#dataSiswa').html(error);
         }
      });

      lastIdKelas = idKelas;
      lastKelas = kelas;
   }

   function cariNamaSiswa() {
      const input = document.getElementById('cariNama').value.toLowerCase();
      const siswaItems = document.querySelectorAll("#dataSiswa .siswa-item");

      siswaItems.forEach(item => {
         const nama = item.innerText.toLowerCase();
         item.style.display = nama.includes(input) ? "" : "none";
      });
   }

   function getDataKehadiran(idPresensi, idSiswa) {
      jQuery.ajax({
         url: "<?= base_url('/admin/absen-siswa/kehadiran'); ?>",
         type: 'post',
         data: { 'id_presensi': idPresensi, 'id_siswa': idSiswa },
         success: function(response) {
            $('#modalFormUbahSiswa').html(response);
         },
         error: function(xhr, status, error) {
            console.log(error);
         }
      });
   }

   function ubahKehadiran() {
      const tanggal = $('#tanggal').val();
      const form = $('#formUbah').serializeArray();
      form.push({ name: 'tanggal', value: tanggal });

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-siswa/edit'); ?>",
         type: 'post',
         data: form,
         success: function(response) {
            if (response['status']) {
               getSiswa(lastIdKelas, lastKelas);
               alert('Berhasil ubah kehadiran: ' + response['nama_siswa']);
            } else {
               alert('Gagal ubah kehadiran: ' + response['nama_siswa']);
            }
         },
         error: function(xhr, status, error) {
            console.log(error);
            alert('Gagal ubah kehadiran\n' + error);
         }
      });
   }
</script>

<?= $this->endSection() ?>
