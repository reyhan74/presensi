<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= $this->include('templates/css'); ?>
   <title>Absensi QR Code</title>
   <style>
<<<<<<< HEAD
      
      :root {
         --bs-primary: #ff5733; /* ganti dengan warna yang kamu mau */
      }
      
=======
      .main-panel .content {
         margin-top: 0 !important;
         padding-top: 0 !important;
      }
>>>>>>> 7db1fe3 (halaman scan)


      .bg {
         background: url(<?= base_url('assets/img/bg2.jpg'); ?>) center;
         opacity: 0.1;
         background-size: cover;
         height: 100vh;
         width: 100%;
         position: absolute;
         left: 0;
         top: 0;
         z-index: -1;
      }

      .main-panel {
         position: relative;
         width: 100%;
         padding-top: 80px; /* agar konten tidak tertutup navbar */
         transition: 0.33s, cubic-bezier(0.685, 0.0473, 0.346, 1);
      }

      video#previewKamera {
         width: 100%;
         height: auto;
         margin: 0;
      }

      .previewParent {
         width: auto;
         height: auto;
         margin: auto;
         border: 2px solid grey;
      }

      .unpreview {
         background-color: aquamarine;
         text-align: center;
      }

      .form-select {
         min-width: 200px;
      }

      .navbar {
         z-index: 1030;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         background-color: rgba(255, 255, 255, 0.95) !important;
         backdrop-filter: blur(5px);
      }

      .navbar .navbar-brand {
         font-weight: bold;
         font-size: 1.2rem;
      }

      @media (max-width: 768px) {
         .navbar .navbar-brand {
            font-size: 1rem;
         }
      }
   </style>
</head>

<body>
   <div class="bg bg-image"></div>

   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light fixed-top">
   <div class="container-fluid">
      <div class="navbar-wrapper w-100">
         <div class="row w-100 align-items-center">
            <!-- Judul -->
            <div class="col-12 col-md-6 order-1 order-md-1 text-start">
               <p class="navbar-brand mb-0"><?= $title ?? 'Login'; ?></p>
            </div>

            <!-- Tombol di sisi kanan (pindah ke bawah di mobile) -->
            <div class="col-12 col-md-6 order-2 order-md-2 d-flex justify-content-start justify-content-md-end mt-2 mt-md-0">
               <?= $this->renderSection('navaction') ?>
            </div>
         </div>
      </div>
   </div>
</nav>

   <!-- End Navbar -->

   <div class="main-panel">
      <?= $this->renderSection('content') ?>
   </div>

   <?= $this->include('templates/js'); ?>
</body>

</html>
