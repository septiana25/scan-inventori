<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <?= form_open($form_action, ['method' => 'POST']) ?>
    <div class="mb-3">
      <label for="barcode" class="form-label d-block">
        <div class="d-flex justify-content-between">
          <h6>Barcode Ban</h6>
          <?php foreach ($content as $row) : ?>
            <h6>PO: <?= $row->suratJalan ?></h6>
          <?php endforeach ?>
        </div>
      </label>
      <?= form_hidden('id_masuk', $input->id_masuk); ?>
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
              <a class="text-decoration-none" href="<?= base_url() . "barangkerak/$row->id_item" ?>">
                <div>
                  <h6><?= $row->item ?></h6>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted fs-6">Rak: A1.1, B1.1</span>
                    <span class="text-muted fs-6">Sisa</span>
                  </div>
                </div>
              </a>
            </td>
            <td>
              <h6><?= $row->qty ?></h6>
              <span class="text-muted fs-6">501</span>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </section>
</main>

<script>
  $(document).ready(function() {

    /* $.ajax({
        url: 'http://192.168.1.21/json.php',
        dataType: 'json',
        success: function (response) {
            var trHTML = '';
            trHTML += '<tbody>';
            $.each(response, function (i, item) {
              const obj1 = Object.assign({}, item);
              console.log(item);
              trHTML += '<tr><td>' + obj1.brcode + '</td><td>' + obj1.qty + '</td></tr>';
            });
            trHTML += '</tbody>';
            $('#records_table').append(trHTML);
        }
      });  */
  });
</script>