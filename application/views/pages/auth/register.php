<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <?= form_open('register', ['method' => 'POST']) ?>
    <div class="mb-3">
      <label for="name" class="form-label">Nama</label>
      <?= form_input('name', $input->name, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Name', 'autofocus' => true]); ?>
      <?= form_error('name') ?>
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <?= form_input('username', $input->username, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Username']); ?>
      <?= form_error('username') ?>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <?= form_password('password', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Password minimal 6 karakter']);
      ?>
      <?= form_error('password') ?>
    </div>
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
      <?= form_password('password_confirmation', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Password yang sama']);
      ?>
      <?= form_error('password_confirmation') ?>
    </div>
    <button type="submit" class="btn btn-primary">Daftar</button>
    <?= form_close() ?>
  </section>
</main>