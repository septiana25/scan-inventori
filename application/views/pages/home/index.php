<main class="container py-4">
  <section id="dashboard">
    <?php $this->load->view('layouts/_alert') ?>
    <h1 class="mt-5 mt-md-5 mt-lg-6 text-center">Halaman Dashboard</h1>
    <div class="row row-cols-2 row-cols-md-3 g-4">
      <div class="col">
        <a href="<?= base_url("returns") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-recycle fa-3x text-success mb-3"></i>
              <h5 class="card-title">Return</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("pickerso") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-hand-pointer-o fa-3x text-success mb-3"></i>
              <h5 class="card-title">Picker SO</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("checkerso") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-clipboard fa-3x text-info mb-3"></i>
              <h5 class="card-title">Checker SO</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("mutasi") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-random fa-3x text-danger mb-3"></i>
              <h5 class="card-title">Mutasi</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("checksaldo") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-balance-scale fa-3x text-warning mb-3"></i>
              <h5 class="card-title">Cek Saldo</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("approved") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-check-circle fa-3x text-primary mb-3"></i>
              <h5 class="card-title">Approved</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>
</main>