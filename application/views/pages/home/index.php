<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <h1>Halaman Dashboard</h1>
    <div class="d-flex justify-content-between">
      <a href="<?= base_url("masuk") ?>" class="btn btn-sm btn-primary">Data Masuk</a>
      <a href="<?= base_url("items") ?>" class="btn btn-sm btn-primary">Cek Saldo Rak</a>
      <a href="<?= base_url("approved") ?>" class="btn btn-sm btn-primary">Approved</a>
    </div>
  </section>
</main>