<main class="container">
    <section id="form">
    <?php $this->load->view('layouts/_alert')?>
        <!-- <form action="<?=base_url('masuk/create')?>" method="post"> -->
        <?= form_open($form_action,  ['method' => 'POST'])?>
            <div class="mb-3">
              <label for="no_plat" class="form-label">Plat Nomor Kendaraan</label>
              <!-- <input type="text" class="form-control" name="suratJalan" id="userName" placeholder="Masukan Surat Jalan" required> -->
              <?= form_input('no_plat', $input->no_plat, ['class' => 'form-control',  'autofocus' => true]); ?>
              <?= form_error('no_plat')?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        <?= form_close()?>

        <table class="table table-sm" id="records_table">
              <thead>
                  <th>Toko</th>
                  <th>No.Faktur</th> 
                  <th>Action</th> 
              </thead>
              <tbody>


              <?php foreach ($content as $row): ?>
                <tr>
                  <td width="30%"><?= $row->toko ?></td>
                  <td width="60%"><?=$row->no_faktur ?></td>
                  <td width="10%">
                    <a href="<?= base_url()."detailmasuk/$row->id_klr"?>" >
                    <button type="button" class="btn btn-primary"
                            style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                    </button> 
                    </a>
                  </td>
                </tr> 
                <?php endforeach ?>                      
              </tbody>
            </table>
            <!-- <nav aria-label="Page navigation example">
                
            </nav> -->
            
    </section>
</main>