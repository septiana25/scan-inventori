<?php
$content = !empty($content) && is_object($content) ? $content : (object) [];
?>
<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Reset Password untuk <?= htmlspecialchars($content->username) ?>
                        </div>
                        <div class="card-body">
                            <?= form_open('profile/reset/' . $content->id_user, ['method' => 'POST', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <?= form_hidden('id_user', $content->id_user); ?>
                                    <?= form_password('new_password', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukkan Password (min. 6 karakter)']); ?>
                                </div>
                                <?= form_error('new_password', '<div class="text-danger mt-1">', '</div>') ?>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <?= form_password('confirm_password', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Masukkan Password yang sama']); ?>
                                </div>
                                <?= form_error('confirm_password', '<div class="text-danger mt-1">', '</div>') ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>