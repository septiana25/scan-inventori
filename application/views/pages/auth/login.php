<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <?= form_open('login', ['method' => 'POST']) ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <?= form_input('username', $input->username, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Usename']); ?>
            <?= form_error('username') ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <?= form_password('password', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukan Password minimal 6 karakter']);
            ?>
            <?= form_error('password') ?>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <?= form_close() ?>
    </section>
</main>