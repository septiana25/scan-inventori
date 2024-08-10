<?php
$currentPage = isset($currentPage) ? $currentPage : 1;
?>
<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <table class="table table-sm" id="records_table">
            <thead>
                <th>Ekspedisi</th>
                <th class="text-center" width="40%">Total Toko</th>
                <th width="5%">Action</th>
            </thead>
            <tbody>

                <?php
                if (!empty($content) && is_object($content) && count((array)$content) > 0):
                    foreach ($content as $row) :
                ?>
                        <tr>
                            <td><?= htmlspecialchars($row->supir) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->count_toko) ?></td>
                            <td>
                                <a href="<?= base_url("checkerso/detail/" . htmlspecialchars($row->nopol)) ?>">
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
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("pickerso/index/" . ($currentPage - 1)) ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url("pickerso/index/$i") ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("pickerso/index/" . ($currentPage + 1)) ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>
</main>
<script>
    $(document).ready(function() {

    });
</script>