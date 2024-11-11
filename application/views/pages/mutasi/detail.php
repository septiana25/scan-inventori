<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <div id="alert-container"></div>
    <!-- Tombol Kembali -->
    <div class="mb-3">
      <a href="<?= base_url('saldorak') ?>" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
      </a>
    </div>
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
      <h6>Daftar Item Mutasi</h6>
    </div>
    <table class="table table-sm pb-5" id="records_table">
      <thead>
        <th width="60%">Item</th>
        <th class="text-center" width="15%">Rak</th>
        <th class="text-center">QTY/Pcs</th>
      </thead>
      <tbody>
        <?php
        if (!empty($content) && is_object($content)):
        ?>
          <tr id="item-row-<?= $content->id_detailsaldo ?>">
            <td>
              <div id="loadingIndicator" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Sedang memproses...</p>
              </div>
              <div>
                <h6><?= $content->brg ?></h6>
                <div class="d-flex justify-content-between">
                </div>
              </div>
            </td>
            <td>
              <h6 class="text-center item-sisa"><?= $content->rak ?></h6>
            </td>
            <td>
              <h6 class="text-center item-sisa"><?= $content->jumlah ?></h6>
            </td>
          </tr>
        <?php
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