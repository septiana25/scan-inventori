<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div id="alert-container"></div>
        <table class="table table-sm" id="records_table">
            <thead>
                <th width="10%" class="fw-bold">Rak</th>
                <th>Item</th>
                <th width="5%" class="text-center fw-bold">Qty</th>
                <th width="5%">Action</th>
            </thead>
            <tbody>
                <?php
                if (!empty($content) && is_iterable($content)):
                    foreach ($content as $row) :
                ?>
                        <tr id="item-<?= $row->id ?>">
                            <td class="fw-bold"><?= htmlspecialchars($row->rak, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($row->brg, ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center fw-bold"><?= htmlspecialchars($row->qty_pro, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <form id="save-item-form">
                                    <input type="hidden" name="id" value="<?= $row->id ?>">
                                    <input type="hidden" name="nopol" value="<?= $nopol ?>">
                                    <input type="hidden" name="supir" value="<?= $supir ?>">
                                    <input type="hidden" name="id_toko" value="<?= $row->id_toko ?>">
                                    <input type="hidden" name="toko" value="<?= $row->toko ?>">
                                    <input type="hidden" name="brg" value="<?= $row->brg ?>">
                                    <input type="hidden" name="id_brg" value="<?= $row->id_brg ?>">
                                    <input type="hidden" name="rak" value="<?= $row->rak ?>">
                                    <input type="hidden" name="qty" value="<?= $row->qty_pro ?>">
                                    <button type="submit" class="btn btn-success btn-icon-prominent">
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                    </button>
                                </form>
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
        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pengambilan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="item-details mt-3">
                            <p><strong>Rak:</strong> <span id="modalRak"></span></p>
                            <p><strong>Item:</strong> <span id="modalItem"></span></p>
                            <p><strong>Qty:</strong> <span id="modalQty"></span></p>
                        </div>
                        <div id="loadingIndicator" class="text-center d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Sedang memproses...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmSave">Ya, Ambil</button>
                    </div>
                </div>
            </div>
        </div>
        </br>
        </br>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const loadingIndicator = document.getElementById('loadingIndicator');
        const confirmSaveBtn = document.getElementById('confirmSave');
        let currentForm = null;
        let isLoading = false;

        document.querySelectorAll('#save-item-form').forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                currentForm = form;

                // Ambil informasi item dari form
                const rak = form.querySelector('input[name="rak"]').value;
                const brg = form.querySelector('input[name="brg"]').value;
                const qty = form.querySelector('input[name="qty"]').value;

                // Isi informasi ke dalam modal
                document.getElementById('modalRak').textContent = rak;
                document.getElementById('modalItem').textContent = brg;
                document.getElementById('modalQty').textContent = qty;

                confirmModal.show();
            });
        });

        confirmSaveBtn.addEventListener('click', () => {
            if (currentForm && !isLoading) {
                isLoading = true;
                // Tampilkan loading indicator dan nonaktifkan tombol
                LoadingIndicator.show(loadingIndicator);
                LoadingIndicator.toggleButton(confirmSaveBtn, true);

                const formData = new FormData(currentForm);
                const data = Object.fromEntries(formData);

                fetch(`<?= base_url("pickerso/save") ?>`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Sembunyikan loading indicator dan aktifkan kembali tombol
                        LoadingIndicator.hide(loadingIndicator);
                        LoadingIndicator.toggleButton(confirmSaveBtn, false);
                        isLoading = false;

                        confirmModal.hide();
                        if (data.status === 'success') {
                            // Cari elemen tr yang merupakan parent dari form
                            const row = currentForm.closest('tr');
                            if (row) {
                                row.style.transition = 'opacity 0.5s';
                                row.style.opacity = '0';
                                setTimeout(() => {
                                    row.remove();
                                    // Periksa apakah tabel masih memiliki baris data
                                    const tbody = document.querySelector('#records_table tbody');
                                    if (tbody && tbody.children.length === 0) {
                                        // Jika tidak ada baris lagi, tampilkan pesan atau sembunyikan tabel
                                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Semua item telah diambil</td></tr>';
                                    }
                                }, 500);
                            }
                            AlertManager.success(data.message);
                        } else {
                            AlertManager.error(data.message);
                        }
                    })
                    .catch((error) => {
                        // Sembunyikan loading indicator dan aktifkan kembali tombol
                        LoadingIndicator.hide(loadingIndicator);
                        LoadingIndicator.toggleButton(confirmSaveBtn, false);
                        isLoading = false;

                        AlertManager.error('Terjadi kesalahan. Silakan coba lagi.');
                    });
            }
        });
    });
</script>
<style>

</style>