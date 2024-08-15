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
                                            <a href="#" class="dropdown-item" onclick="openChangeRoleModal(<?= $row->id_user ?>, '<?= $row->role ?>')">
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
        <!-- Modal Change Role -->
        <div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeRoleModalLabel">Ubah Peran Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="changeRoleForm">
                            <input type="hidden" id="userId" name="userId">
                            <div class="mb-3">
                                <label for="userRole" class="form-label">Peran</label>
                                <select class="form-select" id="userRole" name="userRole" required>
                                    <option value="">Pilih Peran</option>
                                    <option value="superadmin">Superadmin</option>
                                    <option value="admin">Admin</option>
                                    <option value="checkers">Checkers</option>
                                    <option value="pickers">pickers</option>
                                    <option value="member">member</option>
                                    <!-- Tambahkan opsi peran lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveRoleButton">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        </br>
        </br>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi modal
        const changeRoleModal = new bootstrap.Modal(document.getElementById('changeRoleModal'));

        // Fungsi untuk membuka modal
        window.openChangeRoleModal = (userId, currentRole) => {
            document.getElementById('userId').value = userId;
            document.getElementById('userRole').value = currentRole;
            changeRoleModal.show();
        };

        // Event listener untuk tombol simpan
        document.getElementById('saveRoleButton').addEventListener('click', async () => {
            const userId = document.getElementById('userId').value;
            const newRole = document.getElementById('userRole').value;

            try {
                const response = await fetch('<?= base_url("users/changerole") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `id_user=${encodeURIComponent(userId)}&role=${encodeURIComponent(newRole)}`
                });

                await response.json();
            } catch (error) {
                AlertManager.error('Terjadi kesalahan saat mengubah peran.');
            } finally {
                window.location.reload();
            }
        });
    });
</script>