<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="<?= base_url('checkerso/detail/' . $nopol) ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
        <?= form_open($form_action, ['method' => 'POST']) ?>
        <div class="mb-3">
            <label for="rak" class="form-label d-block">
                <div class="d-flex justify-content-between">
                    <h6><?= $toko ?></h6>
                    <h6><?= $supir ?></h6>
                </div>
            </label>
            <?= form_hidden('id_toko', $toko); ?>
            <?= form_input('barcode', $input->barcode, ['class' => 'form-control',  'autofocus' => true, 'placeholder' => 'Scan Item']); ?>
            <?= form_error('barcode') ?>
        </div>
        <div class="mb-3">
            <select class="form-select" id="unit" name="unit">
                <option value="pack">Koli/Karung/Dus</option>
                <option value="pcs">Pcs</option>
            </select>
            <?= form_error('unit') ?>
        </div>
        <?= form_close() ?>
        <div class="d-flex justify-content-center align-item-center">
            <h6>Daftar Item Yang Harus Discan</h6>
        </div>
        <table class="table table-sm pb-5" id="records_table">
            <thead>
                <th width="90%">Item</th>
                <th>QTY/Pcs</th>
            </thead>
            <tbody>
                <?php foreach ($content as $item) : ?>
                    <tr>
                        <td>
                            <div>
                                <h6><?= $item->brg ?></h6>
                                <div class="d-flex justify-content-between">
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="text-center"><?= $item->qty ?></h6>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        </br>
        </br>
    </section>
</main>