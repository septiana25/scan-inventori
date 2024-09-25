<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div id="alert-container"></div>
        <!-- Tombol Kembali -->
        <?= form_open($form_action, ['method' => 'POST']) ?>
        <div class="mb-3">
            <div class="input-group">
                <?= form_input('barcode', isset($input->barcode) ? $input->barcode : '', ['class' => 'form-control', 'id' => 'barcode', 'autofocus' => true, 'placeholder' => 'Scan ' . $field]); ?>
                <?= form_error('barcode') ?>
                <button type="button" id="barcode-button" class="btn btn-outline-secondary">
                    <img src="<?= asset_url('images/barcode.svg') ?>" alt="Barcode" width="20">
                </button>
            </div>
        </div>
        <?= form_close() ?>
        <div class="d-flex justify-content-center align-item-center">
            <h6>Daftar Item Retur</h6>
        </div>
        <table class="table table-sm pb-5" id="records_table">
            <thead>
                <th width="60%">Item</th>
                <th class="text-center" width="15%">Rak</th>
                <th class="text-center">QTY/Pcs</th>
            </thead>
            <tbody>
                <?php
                if (!empty($content) && is_iterable($content)):
                    foreach ($content as $item) :
                ?>
                        <tr id="item-row-<?= $item->id_brg ?>">
                            <td>
                                <div id="loadingIndicator" class="text-center d-none">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Sedang memproses...</p>
                                </div>
                                <div>
                                    <h6><?= $item->brg ?></h6>
                                    <div class="d-flex justify-content-between">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="text-center item-sisa"><?= $item->rak ?></h6>
                            </td>
                            <td>
                                <h6 class="text-center item-sisa"><?= $item->sisa ?></h6>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </br>
        </br>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const barcodeInput = document.getElementById('barcode');
        document.body.addEventListener('click', (event) => {
            barcodeInput.focus();
            if (event.target.id !== 'barcode') {}
        });
    });
</script>