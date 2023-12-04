<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <!-- <form action="<?= base_url('masuk/create') ?>" method="post"> -->
        <div class="d-flex flex-column gap-1 mt-2">
            <a href="<?= base_url('managemasuk') ?>" class="btn  btn-outline-success w-25">Back</a>
            <?php foreach ($content as $row) : ?>
                <div class="d-flex justify-content-between">
                    <h6>NO PO:</h6>
                    <h6><?= $row->suratJalan ?></h6>
                </div>
                <div class="d-flex justify-content-between">
                    <h6><?= $row->item ?></h6>
                    <h6><?= $row->total ?></h6>
                </div>
            <?php endforeach ?>
            <div>
                <form class="row g-3 justify-content-center" action="#" method="POST">
                    <div>
                        <label for="inputQty" class="col-sm-2 col-form-label">Qty</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="inputQty" placeholder="Qty">
                        </div>
                    </div>
                    <div class="mt-0">
                        <label for="inputRak" class="col-sm-2 col-form-label">Rak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputRak" placeholder="Rak">
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <td scope="col-6">Rak</td>
                        <td scope="col-1">Qty</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A1.1</td>
                        <td>23</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td scope="col">Total</th>
                        <td>23</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </section>
</main>
<script>
    $(document).ready(function() {

    });
</script>