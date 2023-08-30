
<main class="container">
            <section id="form">
            <?php $this->load->view('layouts/_alert')?>
                <?= form_open($form_action, ['method' => 'POST']) ?>
                    <div class="mb-3">
                      <h6>Subur Raja Roda</h6>
                      <label for="barcode" class="form-label">Barcode</label>
                        <?= form_hidden('id_keluar', $input->id_keluar);?>
                        <?= form_input('barcode', $input->barcode, ['class' => 'form-control', 'required' => true, 'autofocus' => true]); ?>
                        <?= form_error('barcode') ?>
                        
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                  <?= form_close()?>
                  <table class="table table-sm" id="records_table">
                        <thead>
                            <th width="90%">Item</th>
                            <th>QTY</th> 
                        </thead>
                        <tbody>
                        <?php foreach ($content as $row) : ?>
                          <tr>
                            <td><?= $row->item ?></td>
                            <td><?= $row->qty ?></td>
                          </tr> 
                          <?php endforeach ?>                            
                        </tbody>
                    </table>
                    
            </section>
        </main>

<script>
  $(document).ready(function() {

  });
</script>

