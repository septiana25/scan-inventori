<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <?= form_open($form_action, ['method' => 'POST']) ?>
        <div class="mb-3">
            <label for="rak" class="form-label d-block">
                <div class="d-flex justify-content-between">
                    <h6>Scan Rak</h6>
                    <h6>PO: <?= $content->suratJalan ?></h6>
                </div>
            </label>
            <?= form_hidden('id_masuk', $content->id_masuk); ?>
            <?= form_input('barcodeRak', $input->barcodeRak, ['class' => 'form-control',  'autofocus' => true, 'placeholder' => 'Scan Rak']); ?>
            <?= form_error('barcodeRak') ?>
        </div>
        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        <?= form_close() ?>
    </section>
</main>