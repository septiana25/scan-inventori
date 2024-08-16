<?php
$options = [
    'pack' => 'Koli/Karung/Dus',
    'pcs'  => 'Pcs'
];
?>
<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div id="alert-container"></div>
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="<?= base_url('checkerso/detail/' . $nopol) ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
        <form id="form_scan">
            <div class="mb-3">
                <label for="rak" class="form-label d-block">
                    <div class="d-flex justify-content-between">
                        <h6><?= $toko ?></h6>
                        <h6><?= $supir ?></h6>
                    </div>
                </label>
                <input type="hidden" name="id_toko" value="<?= $id_toko ?>">
                <input type="hidden" name="nopol" value="<?= $nopol ?>">
                <input type="text" name="barcode" id="barcode" class="form-control" autofocus="true" placeholder="Scan Item">
            </div>
            <div class="mb-3">
                <select name="unit" id="unit" class="form-select">
                    <option value="pack" selected>Koli/Karung/Dus</option>
                    <option value="pcs">Pcs</option>
                </select>
            </div>
        </form>
        <div class="d-flex justify-content-center align-item-center">
            <h6>Daftar Item Yang Harus Discan</h6>
        </div>
        <table class="table table-sm pb-5" id="records_table">
            <thead>
                <th width="90%">Item</th>
                <th>QTY/Pcs</th>
            </thead>
            <tbody>
                <?php
                if (!empty($content) && is_iterable($content)):
                    $loadingShown = false;
                    foreach ($content as $item) :
                ?>
                        <tr id="item-row-<?= $item->id_pic ?>">
                            <td>
                                <div id="loadingIndicator" class="text-center d-none">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Sedang memproses...</p>
                                </div>
                                <div>
                                    <h6><?= $item->brg ?></h6>
                                    <div class="d-flex justify-content-between">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="text-center item-sisa"><?= $item->sisa ?></h6>
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
        </br>
        </br>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('form_scan');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const recordsTable = document.getElementById('records_table');
        const barcodeInput = document.getElementById('barcode');
        const unitSelect = document.getElementById('unit');
        let isLoading = false;

        document.body.addEventListener('click', (event) => {
            // Daftar id elemen yang tidak boleh memicu fokus ke input barcode
            const excludedElementIds = ['barcode', 'unit', 'saveRoleButton'];

            // Periksa apakah elemen yang diklik atau parent-nya bukan dari daftar yang dikecualikan
            const isExcluded = excludedElementIds.some(id =>
                event.target.id === id || event.target.closest(`#${id}`)
            );

            // Jika bukan elemen yang dikecualikan, fokuskan ke input barcode
            if (!isExcluded) {
                barcodeInput.focus();
            }
        });

        // Event listener untuk perubahan pada select unit
        unitSelect.addEventListener('change', () => {
            // Fokuskan ke input barcode setelah memilih unit
            setTimeout(() => {
                barcodeInput.focus();
            }, 0);
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Form submitted');

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            console.log('Data to be sent:', data);

            if (!isLoading) {
                isLoading = true;
                LoadingIndicator.show(loadingIndicator);

                fetch('<?= base_url("checkerso/save") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(result => {
                        isLoading = false;
                        LoadingIndicator.hide(loadingIndicator);
                        // Proses respons di sini
                        if (result.status === 'success') {
                            updateTable(result.updatedItems);
                            console.log(result.updatedItems);
                            AlertManager.success(result.message);
                        } else {
                            AlertManager.error(result.message);
                        }
                    })
                    .catch(error => {
                        sLoading = false;
                        LoadingIndicator.hide(loadingIndicator);
                        // Tangani error di sini
                    })
                    .finally(() => {
                        barcodeInput.value = '';
                    });
            }
        });

        function updateTable(updatedItems) {
            updatedItems.forEach(item => {
                const row = document.getElementById(`item-row-${item.id_pic}`);
                if (row) {
                    if (item.sisa === '0' || item.sisa === 0) {
                        // Jika sisa adalah 0, hapus baris
                        row.remove();
                    } else {
                        // Jika tidak, perbarui nilai sisa
                        const sisaElement = row.querySelector('.item-sisa');
                        if (sisaElement) {
                            sisaElement.textContent = item.sisa;
                        }
                    }
                }
            });

            // Periksa apakah tabel kosong setelah pembaruan
            const tableBody = document.querySelector('#records_table tbody');
            if (tableBody && tableBody.children.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="2" class="text-center">Tidak ada data</td></tr>';
            }
        }
    });
</script>