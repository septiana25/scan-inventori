<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div id="alert-container"></div>
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="<?= base_url('checkerso') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
        <table class="table table-sm" id="checker_detail_table">
            <thead>
                <th>Toko</th>
                <th width="15%">Ekspedisi</th>
                <th width="5%">Action</th>
            </thead>
            <tbody>

                <?php
                foreach ($content as $row) :
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row->toko) ?></td>
                        <td><?= htmlspecialchars($row->supir) ?></td>
                        <td>
                            <a href="<?= base_url("checkerso/detail/" . htmlspecialchars($row->nopol)) ?>">
                                <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {

    });
</script>
<style>

</style>