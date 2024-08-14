<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <table class="table table-sm" id="records_table">
            <thead>
                <th width="20%">Nama</th>
                <th width="15%">Username</th>
                <th width="15%">Role</th>
                <th>Status</th>
            </thead>
            <tbody>

                <?php
                if (!empty($content) && is_iterable($content)):
                    foreach ($content as $row) :
                ?>
                        <tr>
                            <td><?= htmlspecialchars($row->name) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->username) ?></td>
                            <td><?= htmlspecialchars($row->role) ?></td>
                            <td>
                                <a href="<?= base_url("users/lock/" . htmlspecialchars($row->id_user)) ?>">
                                    <?php if ($row->is_active == 1) : ?>
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                        </button>
                                    <?php else : ?>
                                        <button type="button" class="btn btn-danger">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </button>
                                    <?php endif; ?>
                                </a>
                                <a href="<?= base_url("users/role/" . htmlspecialchars($row->id_user)) ?>">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
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
        </br>
        </br>
    </section>
</main>
<script>
    $(document).ready(function() {

    });
</script>