<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <table class="table table-sm" id="records_table">
            <thead>
                <th>Ekspedisi</th>
                <th width="5%">Faktur</th>
                <th width="15%">Tanggal</th>
                <th width="5%">Action</th>
            </thead>
            <tbody>

                <?php
                if (!empty($content) && is_iterable($content)):
                    foreach ($content as $row) :
                ?>
                        <tr>
                            <td><?= htmlspecialchars($row->supir) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->faktur) ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tgl)) ?></td>
                            <td>
                                <a href="<?= base_url("pickerso/detail/" . htmlspecialchars($row->nopol)) ?>">
                                    <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </a>
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

        <!-- Pagination -->
        <?= $pagination ?? '' ?>
    </section>
</main>
<script>
    $(document).ready(function() {

    });
</script>