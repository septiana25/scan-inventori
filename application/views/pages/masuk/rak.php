<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <?= form_open($form_action, ['method' => 'POST']) ?>
        <div class="mb-3">
            <label for="rak" class="form-label d-block">
                <div class="d-flex justify-content-between">
                    <h6>Scan Rak</h6>
                    <h6>PO: <?= $content->suratJln ?></h6>
                </div>
            </label>
            <?= form_hidden('id_masuk', $content->idMsk); ?>
            <?= form_input('barcodeRak', $input->barcodeRak, ['class' => 'form-control',  'autofocus' => true, 'placeholder' => 'Scan Rak']); ?>
            <?= form_error('barcodeRak') ?>
        </div>
        <?= form_close() ?>
        <div class="d-flex justify-content-center align-item-center">
            <h6>Daftar Item ke Storage</h6>
        </div>
        <table class="table table-sm" id="records_table">
            <thead>
                <th width="90%">Item</th>
                <th>QTY</th>
            </thead>
            <tbody>
                <?php foreach ($content->items as $item) : ?>
                    <tr>
                        <td>
                            <div>
                                <h6><?= $item->brg ?></h6>
                                <div class="d-flex justify-content-between">
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6><?= $item->qty_po ?></h6>
                            <span class="text-muted fs-5"><?= $item->rak ?></span>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</main>