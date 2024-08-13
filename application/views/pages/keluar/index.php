<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <table class="table table-sm" id="records_table">
      <thead>
        <th>Ekspedisi</th>
        <th>Tanggal</th>
        <th>Action</th>
      </thead>
      <tbody>


        <?php if (!empty($content) && is_iterable($content)):
          foreach ($content as $row) : ?>
            <tr>
              <td width="30%"><?= $row->supir ?></td>
              <td width="60%"><?= $row->at_create ?></td>
              <td width="10%">
                <a href="<?= base_url() . "/keluar/print/$row->nopol" ?>">
                  <button type="button" class="btn btn-primary"
                    style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                    <i class="fa fa-print" aria-hidden="true"></i>
                  </button>
                </a>
              </td>
            </tr>
        <?php
          endforeach;
        endif; ?>
      </tbody>
    </table>
    <!-- <nav aria-label="Page navigation example">
                
            </nav> -->

  </section>
</main>