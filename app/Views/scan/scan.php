<?php

// view file: scan_absen.php (misal)

?>
<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<a href="<?= base_url('/admin'); ?> " class="btn btn-primary pull-right pl-3">
   <i class="material-icons mr-2">dashboard</i>
   Dashboard
</a>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<?php
   $oppBtn = '';
   $waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
?>

<style>
.camera-wrapper {
   position: relative;
   width: 100%;
   max-height: 500px;
   overflow: hidden;
   background-color: #000;
   border-radius: 10px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

#previewKamera {
   width: 100%;
   height: auto;
   display: block;
   border-radius: 10px;
   object-fit: contain;
   transition: all 0.3s ease-in-out;
}

.card {
   box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
   transition: transform 0.2s ease-in-out;
}

.card:hover {
   transform: translateY(-2px);
}

.dropdown-menu a:hover {
   background-color: #f1f1f1;
   font-weight: bold;
}

#clock {
   font-family: 'Courier New', Courier, monospace;
   letter-spacing: 2px;
}
</style>

<div class="main-panel">
   <div >
      <div class="container-fluid">
         <div class="row">
            <div class="col-12 col-md-6 col-lg-3 col-xl-4 mb-4">
               <div class="card animate__animated animate__fadeInUp">
                  <div class="card-body">
                     <h3 class="mt-2"><b>Tips</b></h3>
                     <ul class="pl-3">
                        <li>Tunjukkan qr code sampai terlihat jelas di kamera</li>
                        <li>Posisikan qr code tidak terlalu jauh maupun terlalu dekat</li>
                     </ul>
                  </div>
               </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4">
               <div class="card animate__animated animate__fadeInUp">
                  <div class="col-11 mx-auto card-header card-header-primary">
                     <div class="row">
                        <div class="col">
                           <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                           <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                        </div>
                        <div class="col-md-auto">
                           <div class="dropdown">
                           <?php
                              $labelAbsen = 'Pilih Jenis Absen';
                              $btnColor = 'primary';
                              switch (strtolower($waktu)) {
                                 case 'masuk': $labelAbsen = 'Absen Masuk'; $btnColor = 'success'; break;
                                 case 'pulang': $labelAbsen = 'Absen Pulang'; $btnColor = 'warning'; break;
                                 case 'izin': $labelAbsen = 'Absen Izin'; $btnColor = 'info'; break;
                              }
                           ?>
                           </div>
                           <div class="dropdown mt-2">
                              <button class="btn btn-<?= $btnColor ?> dropdown-toggle w-100" type="button" id="dropdownAbsen" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="material-icons mr-1" style="vertical-align: middle;">event</i>
                                 <?= $labelAbsen ?>
                              </button>
                              <div class="dropdown-menu shadow-sm border-0 rounded-lg p-2 animate__animated animate__fadeIn" aria-labelledby="dropdownAbsen">
                                 <a class="dropdown-item d-flex align-items-center text-success" href="<?= base_url("scan/masuk"); ?>">
                                    <i class="material-icons mr-2">login</i> Absen Masuk
                                 </a>
                                 <a class="dropdown-item d-flex align-items-center text-warning" href="<?= base_url("scan/pulang"); ?>">
                                    <i class="material-icons mr-2">logout</i> Absen Pulang
                                 </a>
                                 <a class="dropdown-item d-flex align-items-center text-info" href="<?= base_url("scan/izin"); ?>">
                                    <i class="material-icons mr-2">event_busy</i> Absen Izin
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="card-body my-auto px-3">
                     <h4 class="d-inline">Pilih kamera</h4>
                     <select id="pilihKamera" class="custom-select w-100 mt-2" aria-label="Default select example" style="height: 35px;">
                        <option selected>Select camera devices</option>
                     </select>

                     <br><br>

                     <div class="row">
                        <div class="col-12 mx-auto">
                           <div class="camera-wrapper">
                              <video id="previewKamera" autoplay playsinline muted></video>
                           </div>
                        </div>
                     </div>

                     <div id="hasilScan"></div>
                  </div>
               </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3 col-xl-4 mb-4">
               <div class="card bg-gradient bg-success text-white shadow rounded-lg">
                  <br>
                  <div class="col-12 text-center mb-2">
                     <h2 id="clock" class="font-weight-bold text-white"></h2>
                  </div>
               </div>
               <div class="card animate__animated animate__fadeInUp">
                  <div class="card-body">
                     <h3 class="mt-2"><b>Penggunaan</b></h3>
                     <ul class="pl-3">
                        <li>Jika berhasil scan maka akan muncul data siswa/guru dibawah preview kamera</li>
                        <li>Klik tombol <b><span class="text-success">Absen masuk</span> / <span class="text-warning">Absen pulang</span></b> untuk mengubah waktu absensi</li>
                        <li>Untuk melihat data absensi, klik tombol <span class="text-primary"><i class="material-icons" style="font-size: 16px;">dashboard</i> Dashboard Petugas</span></li>
                        <li>Untuk mengakses halaman petugas anda harus login terlebih dahulu</li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="<?= base_url('assets/js/plugins/zxing/zxing.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/jquery-3.5.1.min.js') ?>"></script>
<script>
let selectedDeviceId = null;
let audio = new Audio("<?= base_url('assets/audio/beep.mp3'); ?>");
const codeReader = new ZXing.BrowserMultiFormatReader();
const sourceSelect = $('#pilihKamera');

$(document).on('change', '#pilihKamera', function() {
   selectedDeviceId = $(this).val();
   if (codeReader) {
      codeReader.reset();
      initScanner();
   }
});

function initScanner() {
   codeReader.listVideoInputDevices()
      .then(videoInputDevices => {
         if (videoInputDevices.length < 1) {
            alert("Camera not found!");
            return;
         }

         if (!selectedDeviceId) {
            selectedDeviceId = videoInputDevices[0].deviceId;
         }

         sourceSelect.html('');
         videoInputDevices.forEach(device => {
            const option = $('<option>').val(device.deviceId).text(device.label);
            if (device.deviceId === selectedDeviceId) option.attr('selected', true);
            sourceSelect.append(option);
         });

         codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
            .then(result => {
               cekData(result.text);
               audio.play();
               $('#previewKamera').addClass('d-none');
               setTimeout(() => {
                  codeReader.reset();
                  $('#previewKamera').removeClass('d-none');
                  initScanner();
               }, 2500);
            })
            .catch(err => console.error(err));
      })
      .catch(err => console.error(err));
}

if (navigator.mediaDevices) {
   initScanner();
} else {
   alert('Cannot access camera.');
}

function cekData(code) {
   if (!navigator.geolocation) return alert('Geolocation tidak didukung browser Anda');

   navigator.geolocation.getCurrentPosition(pos => {
      const lat = pos.coords.latitude;
      const lon = pos.coords.longitude;

      $.post("<?= base_url('scan/cek'); ?>", {
         unique_code: code,
         waktu: "<?= strtolower($waktu); ?>",
         latitude: lat,
         longitude: lon
      }, response => {
         $('#hasilScan').html(response);
         $('html, body').animate({ scrollTop: $('#hasilScan').offset().top }, 500);
      }).fail((xhr, status, error) => {
         $('#hasilScan').html(error);
      });
   }, error => alert("Gagal mendapatkan lokasi: " + error.message));
}

function updateClock() {
   const now = new Date();
   const hours = String(now.getHours()).padStart(2, '0');
   const minutes = String(now.getMinutes()).padStart(2, '0');
   const seconds = String(now.getSeconds()).padStart(2, '0');
   const timeString = `${hours}:${minutes}:${seconds}`;
   document.getElementById('clock').innerText = timeString;
}
setInterval(updateClock, 1000);
updateClock();
</script>


<?= $this->endSection(); ?>
