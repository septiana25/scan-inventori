<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <?= form_open($form_action, ['method' => 'POST']) ?>
    <div class="mb-3">
      <div class="input-group">
        <div class="input-group">
          <?= form_input('barcodeRak', isset($input->barcodeRak) ? $input->barcodeRak : '', ['class' => 'form-control', 'id' => 'barcodeRak', 'autofocus' => true, 'placeholder' => 'Scan Rak']); ?>
          <?= form_error('barcodeRak') ?>
          <button type="button" id="barcode-button" class="btn btn-outline-secondary">
            <img src="<?= asset_url('images/barcode.svg') ?>" alt="Barcode" width="20">
          </button>
        </div>
      </div>
      <?= form_close() ?>
      <div class="d-flex justify-content-center align-item-center">
        <h6>Daftar Item</h6>
      </div>
      <table class="table table-sm" id="records_table">
        <thead>
          <th width="90%">Item</th>
          <th>QTY</th>
        </thead>
        <tbody>
          <?php
          if (!empty($content) && is_iterable($content)):
            foreach ($content as $items) : ?>
              <tr>
                <td>
                  <div>
                    <h6><?= $items->brg ?></h6>
                    <div class="d-flex flex-column">
                      <?php foreach ($items->details as $key => $item) : ?>
                        <div class="d-flex justify-content-between mb-2 <?= $key < count($items->details) - 1 ? 'border-bottom pb-2 mb-2' : '' ?>">
                          <span class="text-muted fs-6 flex-grow-1 flex-basis-0">Rak: <?= $item->rak ?></span>
                          <span class="text-muted fs-6 flex-grow-1 flex-basis-0">Tahun: <?= $item->tahunprod ?></span>
                          <span class="text-muted fs-6 flex-grow-1 flex-basis-0">QTY: <?= $item->jumlah ?></span>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </td>
                <td>
                  <h6><?= $items->saldo_akhir ?></h6>
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
  </section>
</main>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const barcodeInput = document.getElementById('barcodeRak');
    document.body.addEventListener('click', (event) => {
      barcodeInput.focus();
      if (event.target.id !== 'barcodeRak') {}
    });
  });
</script>