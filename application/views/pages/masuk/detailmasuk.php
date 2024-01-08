<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <?= form_open($form_action, ['method' => 'POST']) ?>
    <div class="mb-3">
      <label for="barcode" class="form-label d-block">
        <a href="<?= base_url("rakmasuk/$contentHeader->id_masuk") ?>" class="btn btn-sm btn-primary">Kembali</a>
        <div class="d-flex justify-content-between">
          <h6>Rak: <?= $contentHeader->rak ?></h6>
          <h6>PO: <?= $contentHeader->suratJalan ?></h6>
        </div>
      </label>
      <?= form_hidden('id_masuk', $input->id_masuk); ?>
      <?= form_hidden('id_rak', $input->id_rak); ?>
      <?= form_hidden('rak', $input->rak); ?>
      <?= form_input('barcode', $input->barcode, ['class' => 'form-control', 'required' => true, 'autofocus' => true, 'placeholder' => 'Scan Barcode Ban']); ?>
      <?= form_error('barcode') ?>
    </div>
    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
    <?= form_close() ?>
    <table class="table table-sm" id="records_table">
      <thead>
        <th width="90%">Item</th>
        <th>QTY</th>
      </thead>
      <tbody>
        <?php foreach ($content as $row) : ?>
          <tr>
            <td>
              <h6><?= $row->item ?></h6>
            </td>
            <td>
              <h6><?= $row->qty ?></h6>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </section>
</main>