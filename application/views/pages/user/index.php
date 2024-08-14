<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <table class="table table-sm" id="records_table">
            <thead>
                <th>Nama</th>
                <th width="15%">Username</th>
                <th width="15%">Role</th>
                <th width="15%">Aksi</th>
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
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton<?= $row->id_user ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $row->id_user ?>">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url("users/lock/" . htmlspecialchars($row->id_user)) ?>">
                                                <?php if ($row->is_active == 1) : ?>
                                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i> Aktif
                                                <?php else : ?>
                                                    <i class="fa fa-lock" aria-hidden="true"></i> Nonaktif
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url("users/role/" . htmlspecialchars($row->id_user)) ?>">
                                                <i class="fa fa-low-vision" aria-hidden="true"></i> Ubah Role
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url("users/resetdefault/" . htmlspecialchars($row->id_user)) ?>">
                                                <i class="fa fa-refresh" aria-hidden="true"></i> Password Default
                                            </a>
                                        </li>
                                    </ul>
                                </div>
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