<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <div id="alert-container"></div>
    <div class="d-flex justify-content-center align-item-center">
      <h6>Daftar Item Mutasi Belum Diproses</h6>
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
            <tr id="item-row-<?= $item->id_detailsaldo ?>">
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
                <h6 class="text-center item-sisa"><?= $item->rak_asal . ' <i class="fa fa-long-arrow-right" aria-hidden="true"></i> ' . $item->rak_tujuan ?></h6>
              </td>
              <td>
                <h6 class="text-center item-sisa"><?= $item->qty ?></h6>
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