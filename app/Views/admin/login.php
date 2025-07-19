<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<a href="<?= base_url('/'); ?>" class="btn btn-info pull-right pl-3">
   <i class="material-icons mr-2">qr_code</i>
   Scan QR
</a>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="main-panel">
   <div class="content">
      <div class="container-fluid">
         <div class="row justify-content-center">
            <div class="col-md-4"> <!-- Ubah dari col-md-6 ke col-md-4 -->
               <div class="card shadow-lg rounded-lg border-0 animate__animated animate__fadeInDown">
                  <div class="card-header bg-gradient-info text-white text-center py-4">
                     <!-- Logo SMK -->
                     <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo SMK" class="mb-2" style="max-height: 80px;">
                     <h4 class="card-title font-weight-bold">Login</h4>
                     <p class="card-category font-weight-bold mb-0">SMK CANDA BHIRAWA PARE</p>
                  </div>

                  <div class="card-body px-4 py-4"> <!-- Sedikit kurangi padding -->
                     <?= view('\App\Views\admin\_message_block') ?>
                     <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <?php if ($config->validFields === ['email']) : ?>
                        <div class="form-group">
                           <label><?= lang('Auth.email') ?></label>
                           <input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" autofocus>
                           <div class="invalid-feedback">
                              <?= session('errors.login') ?>
                           </div>
                        </div>
                        <?php else : ?>
                        <div class="form-group">
                           <label><?= lang('Auth.emailOrUsername') ?></label>
                           <input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" autofocus>
                           <div class="invalid-feedback">
                              <?= session('errors.login') ?>
                           </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group mt-3">
                           <label>Password</label>
                           <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>">
                           <div class="invalid-feedback">
                              <?= session('errors.password') ?>
                           </div>
                        </div>

                        <?php if ($config->allowRemembering) : ?>
                        <div class="form-check mt-3">
                           <input type="checkbox" name="remember" class="form-check-input" id="rememberMe" <?php if (old('remember')) : ?> checked <?php endif ?>>
                           <label class="form-check-label" for="rememberMe">
                              <?= lang('Auth.rememberMe') ?>
                           </label>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-info btn-block mt-4">
                           <i class="material-icons mr-1">login</i> <?= lang('Auth.loginAction') ?>
                        </button>

                        <?php if ($config->activeResetter) : ?>
                        <div class="text-center mt-3">
                           <a href="<?= url_to('forgot') ?>" class="text-secondary">
                              <small><?= lang('Auth.forgotYourPassword') ?></small>
                           </a>
                        </div>
                        <?php endif; ?>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>
