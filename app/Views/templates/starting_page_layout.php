<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= $this->include('templates/css'); ?>
   <title><?= $title ?? 'Absensi QR Code'; ?></title>
   <style>
      .main-panel {
         position: relative;
         width: 100%;
         padding-top: 80px;
         transition: 0.33s cubic-bezier(0.685, 0.0473, 0.346, 1);
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
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <div class="container-fluid">
         <div class="navbar-wrapper w-100">
            <div class="row w-100 align-items-center">
               <div class="col-12 col-md-6 order-1 text-start">
                  <p class="navbar-brand mb-0"><?= $title ?? 'Login'; ?></p>
               </div>
               <div class="col-12 col-md-6 order-2 d-flex justify-content-start justify-content-md-end mt-2 mt-md-0">
                  <?= $this->renderSection('navaction') ?>
               </div>
            </div>
         </div>
      </div>
   </nav>

   <div class="main-panel">
      <?= $this->renderSection('content') ?>
   </div>

   <?= $this->include('templates/js'); ?>
</body>
</html>
