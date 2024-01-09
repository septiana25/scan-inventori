<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <h1>Halaman Profile</h1>
    <div class="d-flex gap-1">
      <h2>Hi!
        <h3 class=""> <?= $data ?></h3>
      </h2>
    </div>
    <div class="d-flex justify-content-between">
      <a href="<?= base_url("logout") ?>" class="btn btn-sm btn-primary">Logout</a>
    </div>
  </section>
</main>