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
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton<?= $row->nopol ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $row->nopol ?>">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url("keluar/print/" . htmlspecialchars($row->nopol)) ?>">
                                                <i class="fa fa-print" aria-hidden="true"></i> Print
                                            </a>
                                        </li>
                                    </ul>
                                </div>
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