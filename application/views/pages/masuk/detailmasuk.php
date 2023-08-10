
<main class="container">
            <section id="form">
            <?php $this->load->view('layouts/_alert')?>
                <?= form_open($form_action, ['method' => 'POST']) ?>
                    <div class="mb-3">
                      <label for="item" class="form-label">Item</label>
                        <?= form_input('item', $input->item, ['class' => 'form-control', 'required' => true, 'autofocus' => true]); ?>
                        <?= form_error('item') ?>
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

