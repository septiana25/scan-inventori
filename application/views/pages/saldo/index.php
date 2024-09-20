<main class="container py-4">
  <section id="dashboard">
    <?php $this->load->view('layouts/_alert') ?>
    <h1 class="mt-5 mt-md-5 mt-lg-6 text-center">Menu Check Saldo</h1>
    <div class="row row-cols-2 row-cols-md-3 g-4">
      <div class="col">
        <a href="<?= base_url("saldoitem") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-shopping-basket fa-3x text-primary mb-3"></i>
              <h5 class="card-title">Saldo Item</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= base_url("saldorak") ?>" class="text-decoration-none">
          <div class="card h-100 text-center shadow-sm">
            <div class="card-body d-flex flex-column justify-content-center">
              <i class="fa fa-cubes fa-3x text-success mb-3"></i>
              <h5 class="card-title">Saldo Rak</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>
</main>