<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <?php foreach ($content as $row) : ?>

            <div class="accordion accordion-flush pb-2" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-<?= $row->id_item ?>" aria-expanded="false" aria-controls="flush-collapseOne-<?= $row->id_item ?>">
                            <div class="d-flex justify-content-between flex-shrink-1 flex-grow-1">
                                <p class="pb-0"><?= $row->item ?></p>
                                <p class="pb-0 pe-3"><?= $row->total ?></p>
                            </div>
                        </button>
                    </h2>
                    <div id="flush-collapseOne-<?= $row->id_item ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne-<?= $row->id_item ?>" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body border border-primary">
                            <!-- <button type="button" class="btn btn-warning w-100">Posting</button> -->
                            <div class="d-flex flex-column gap-1 mt-2">
                                <!-- <p>Surat Jalan: <span>B-12345</span></p> -->
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col-6">Rak</th>
                                            <th scope="col-6">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $total = 0;
                                        foreach ($row->data as $detail) : ?>
                                            <tr>
                                                <td><?= $detail['rak'] ?></td>
                                                <td><?= $detail['qty'] ?></td>
                                            </tr>
                                        <?php
                                            $total = $total + $detail['qty'];
                                        endforeach ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">Total</th>
                                            <td><?= $total ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- <div class="d-flex justify-content-between">
                                        <span>Rak</span>
                                        <span>Qty</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>A1.1</span>
                                        <span>25</span>
                                    </div> 
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <span>Total</span>
                                    <span>25</span>
                                </div>-->
                                <div>

                                    <?= form_open($form_action, ['method' => 'POST'], ['class' => 'row g-3 justify-content-center']) ?>
                                    <!-- <form class="row g-3 justify-content-center" action="#" method="POST"> -->
                                    <div class="d-flex gap-2 input-group-md pt-2">
                                        <?= form_dropdown('SuratJalan', $suratJalan, '', 'class ="form-control"') ?>
                                        <!-- <select class="form-select" aria-label="Pilih Rak" require="true">
                                                <option selected>Pilih Surat Jalan</option>
                                                <option value="1">B-2534</option>
                                                <option value="2">B-3568</option>
                                                <option value="3">C-8285</option>
                                            </select> -->
                                    </div>
                                    <div class="d-flex gap-2 input-group-md pt-2">
                                        <?= form_dropdown('rak', $rak, '', 'class ="form-control"') ?>
                                        <!-- <select class="form-select" aria-label="Pilih Rak" require="true">
                                                <option selected>Pilih Rak</option>
                                                <option value="1">A1.1</option>
                                                <option value="2">B1.1</option>
                                                <option value="3">C1.1</option>
                                            </select> -->
                                        <?= form_input('qty', $input->qty, ['class' => 'form-control', 'required' => true, 'placeholder' => 'QTY']); ?>
                                        <!-- <input type="number" class="form-control" id="qty" placeholder="QTY" require="true"> -->
                                        <button type="submit" class="btn btn-primary">simpan</button>
                                    </div>
                                    <!-- </form> -->
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </section>
</main>