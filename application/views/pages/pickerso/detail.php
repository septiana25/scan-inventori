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
                <?php foreach ($content as $row) : ?>
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
                                <input type="hidden" name="rak" value="<?= $row->rak ?>">
                                <input type="hidden" name="qty" value="<?= $row->qty_pro ?>">
                                <button type="submit" class="btn btn-success btn-icon-prominent">
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("pickerso/detail/$nopol/" . ($currentPage - 1)) ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url("pickerso/detail/$nopol/$i") ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("pickerso/detail/$nopol/" . ($currentPage + 1)) ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#save-item-form').forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                // Tambahkan konfirmasi di sini
                if (!confirm('Apakah Anda yakin ingin menyimpan item ini?')) {
                    return; // Jika user membatalkan, hentikan eksekusi fungsi
                }


                const formData = new FormData(form);
                const data = Object.fromEntries(formData);

                fetch(`<?= base_url("pickerso/save") ?>`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Cari elemen tr yang merupakan parent dari form
                            const row = form.closest('tr');
                            if (row) {
                                // Animasi fade out sebelum menghapus
                                row.style.transition = 'opacity 0.5s';
                                row.style.opacity = '0';
                                setTimeout(() => {
                                    row.remove();
                                    // Periksa apakah tabel masih memiliki baris data
                                    const tbody = document.querySelector('#records_table tbody');
                                    if (tbody && tbody.children.length === 0) {
                                        // Jika tidak ada baris lagi, tampilkan pesan atau sembunyikan tabel
                                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Semua item telah disimpan</td></tr>';
                                    }
                                }, 500);
                            }

                            // Tampilkan pesan flash
                            showAlert('success', data.message);
                        } else {
                            // Tampilkan pesan error
                            showAlert('error', data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
                    });
            });
        });

        // Fungsi untuk menampilkan alert
        const showAlert = (type, message) => {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 mt-md-5" role="alert" style="z-index: 9999;">
                <strong>${type}</strong> ${message}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

            // Tambahkan alert ke dalam container
            document.getElementById('alert-container').innerHTML = alertHtml;

            // Hilangkan alert setelah 5 detik
            setTimeout(() => {
                const alertElement = document.querySelector('.alert');
                if (alertElement) alertElement.remove();
            }, 5000);
        };
    });
</script>
<style>
    .btn-icon-prominent {
        padding: 0.5rem 0.7rem;
        transition: all 0.3s ease;
    }

    .btn-icon-prominent i {
        font-size: 1.2rem;
    }

    .btn-icon-prominent:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    #save-item-form {
        margin: 0;
    }
</style>