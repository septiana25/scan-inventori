<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <!-- <form action="<?= base_url('masuk/create') ?>" method="post"> -->
        <table class="table table-sm" id="records_table">
            <thead>
                <th width="60%">Nama Barang</th>
            </thead>
            <tbody>

                <?php foreach ($content as $row) : ?>
                    <tr>
                        <td>
                            <a class="text-decoration-none" href="<?= base_url() . "barangkerak/$row->id_item" ?>">
                                <div>
                                    <h6><?= $row->item ?></h6>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted fs-6">PO: <?= $row->suratJalan ?></span>
                                        <span class="text-muted fs-6">Qty: <?= $row->total ?></span>
                                    </div>
                                </div>
                            </a>
                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <!-- <nav aria-label="Page navigation example">
                <td><?= $row->suratJalan ?></td>
                        <td><?= $row->total ?></td>
            </nav> -->

    </section>
</main>
<script>
    $(document).ready(function() {

    });
</script>