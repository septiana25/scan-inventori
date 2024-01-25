<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <table class="table table-sm" id="records_table">
            <thead>
                <th width="75%">List</th>
                <th>Approve</th>
            </thead>
            <tbody>

                <?php foreach ($content as $list) : ?>
                    <tr>
                        <td>
                            <div>
                                <h6><?= $list->rak ?></h6>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">checker: <?= $list->user ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="<?= base_url() . "approved/upproverak/$list->id" ?>">
                                <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            </a>
                            <a href="<?= base_url() . "approved/cancelrak/$list->id" ?>">
                                <button type="button" class="btn btn-danger" style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .50rem;">
                                    <i class="fa fa-times" aria-hidden="true"></i>
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