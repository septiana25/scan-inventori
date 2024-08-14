<?php
$content = !empty($content) && is_object($content) ? $content : (object) [];
?>
<main class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow">
        <div class="card-body p-4">
          <?php $this->load->view('layouts/_alert') ?>
          <h2 class="card-title text-center mb-4">Profil Pengguna</h2>

          <div class="text-center mb-4">
            <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size: 100px; color: #dc3545;"></i>
          </div>

          <div class="mb-3 text-center">
            <h3>Halo, <?= htmlspecialchars($content->user) ?>!</h3>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Username:</label>
            <p class="form-control-plaintext"><?= htmlspecialchars($content->user) ?></p>
          </div>

          <?php if ($email ?? false) : ?>
            <div class="mb-3">
              <label class="form-label fw-bold">Email:</label>
              <p class="form-control-plaintext"><?= htmlspecialchars($content->user) ?></p>
            </div>
          <?php endif; ?>

          <?php if ($joined_date ?? false) : ?>
            <div class="mb-3">
              <label class="form-label fw-bold">Bergabung Sejak:</label>
              <p class="form-control-plaintext"><?= htmlspecialchars($content->user) ?></p>
            </div>
          <?php endif; ?>

          <?php if ($content->role == 'superadmin') : ?>
            <div class="d-grid gap-2 mt-4">
              <a href="<?= base_url("users") ?>" class="btn btn-success">Data User</a>
            </div>
          <?php endif; ?>

          <div class="d-grid gap-2 mt-4">
            <a href="<?= base_url("profile/reset/$content->id_user") ?>" class="btn btn-primary">Reset Password</a>
          </div>

          <div class="d-grid gap-2 mt-4">
            <a href="<?= base_url("logout") ?>" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<style>
  body {
    background-color: #f8f9fa;
  }

  .card {
    margin-top: 2rem;
    border: none;
    border-radius: 1rem;
  }

  .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .btn-danger:hover {
    background-color: #bb2d3b;
    border-color: #b02a37;
  }
</style>