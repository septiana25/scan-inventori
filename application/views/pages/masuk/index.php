<main class="container">
  <section id="form">
    <?php $this->load->view('layouts/_alert') ?>
    <table class="table table-sm" id="records_table">
      <thead>
        <th width="90%">Surat Jalan</th>
        <th>Action</th>
      </thead>
      <tbody>

        <?php foreach ($content as $row) : ?>
          <tr>
            <td><?= $row->suratJln ?></td>
            <td>
              <a href="<?= base_url() . "rakmasuk/$row->id_msk" ?>">
                <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
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
<script>
  $(document).ready(function() {

  });
</script>