<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <?= form_open($form_action, ['method' => 'POST']) ?>
        <div class="mb-3">
            <label for="rak" class="form-label d-block">
                <div class="d-flex justify-content-between">
                    <h6>Scan Rak</h6>
                    <?php foreach ($content as $row) : ?>
                        <h6>PO: <?= $row->suratJalan ?></h6>
                    <?php endforeach ?>
                </div>
            </label>
            <?= form_hidden('id_masuk', $input->id_masuk); ?>
            <?= form_input('rak', $input->barcode, ['class' => 'form-control', 'required' => true, 'autofocus' => true, 'placeholder' => 'Scan Rak']); ?>
            <?= form_error('rak') ?>
        </div>
        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        <?= form_close() ?>
    </section>
</main>