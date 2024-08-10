<main class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Login</h2>

                    <?php $this->load->view('layouts/_alert') ?>

                    <?= form_open('login', ['method' => 'POST', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <?= form_input('username', isset($input->username) ? $input->username : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukkan Username']); ?>
                        </div>
                        <?= form_error('username', '<div class="text-danger mt-1">', '</div>') ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            <?= form_password('password', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukkan Password']); ?>
                        </div>
                        <?= form_error('password', '<div class="text-danger mt-1">', '</div>') ?>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                    <?= form_close() ?>

                    <div class="text-center mt-3">
                        <a href="register" class="text-decoration-none">Buat Akun Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    body {
        background-color: #f8f9fa;
        /* Ganti dengan warna latar belakang yang sesuai */
    }

    .card {
        border: none;
        border-radius: 1rem;
    }

    .btn-primary {
        background-color: #FF6263;
        /* Ganti dengan warna primer aplikasi Anda */
        border-color: #FF6263;
    }

    .btn-primary:hover {
        background-color: #d25051;
        /* Warna hover, sesuaikan jika perlu */
        border-color: #d25051;
    }
</style>