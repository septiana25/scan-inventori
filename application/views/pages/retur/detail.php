<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
        <div id="alert-container"></div>
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="<?= base_url('returns') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
        <form id="form_scan">
            <div class="mb-3">
                <label for="rak" class="form-label d-block">
                    <div class="d-flex justify-content-between">
                        <h6>Rak: <?= $rak ?></h6>
                    </div>
                </label>
                <input type="hidden" name="idRak" value="<?= $idRak ?>">
                <input type="text" name="barcode" id="barcode" class="form-control" autofocus="true" placeholder="Scan Item">
            </div>
            <div class="mb-3">
                <select name="unit" id="unit" class="form-select">
                    <option value="pcs">Pcs</option>
                    <option value="pack" selected>Koli/Karung/Dus</option>
                </select>
            </div>
        </form>
        <div class="d-flex justify-content-center align-item-center">
            <h6>Daftar Item Sudah Discan</h6>
        </div>
        <table class="table table-sm pb-5" id="records_table">
            <thead>
                <th width="60%">Item</th>
                <th class="text-center" width="15%">Rak</th>
                <th class="text-center">QTY/Pcs</th>
            </thead>
            <tbody id="item-list">
                <?php
                if (!empty($content) && is_iterable($content)):
                    foreach ($content as $item) :
                ?>
                        <tr id="item-row" data-id-brg="<?= $item->id_brg ?>" data-id-rak="<?= $item->id_rak ?>" class>
                            <td>
                                <div id="loadingIndicator" class="text-center d-none">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Sedang memproses...</p>
                                </div>
                                <div>
                                    <h6 id="item-brg"><?= $item->brg ?></h6>
                                    <div class="d-flex justify-content-between">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="text-center item-sisa" id="item-rak"><?= $item->rak ?></h6>
                            </td>
                            <td>
                                <h6 class="text-center item-sisa" id="item-sisa"><?= $item->sisa ?></h6>
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
        const barcodeInput = document.getElementById('barcode');
        const unitSelect = document.getElementById('unit');

        document.body.addEventListener('click', (event) => {
            // Daftar id elemen yang tidak boleh memicu fokus ke input barcode
            const excludedElementIds = ['barcode', 'unit'];

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

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            console.log(data);

            fetch('<?= base_url("returns/save") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            }).then(response => {
                return response.json();
            }).then(result => {
                if (result.status === 'success') {
                    updateTable(result.data.returns);
                    AlertManager.success('Berhasil');
                } else {
                    AlertManager.error(result.message);
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });

        function updateTable(updatedItems) {
            const tableBody = document.querySelector('#records_table tbody');

            updatedItems.forEach(item => {
                let row = document.querySelector(`tr[data-id-brg="${item.id_brg}"][data-id-rak="${item.id_rak}"]`);

                if (row) {
                    // Update existing row
                    updateRow(row, item);
                } else {
                    // Create new row
                    row = createNewRow(item);
                    tableBody.appendChild(row);
                }

                // Highlight the updated/new row
                row.classList.add('table-warning');
                setTimeout(() => {
                    row.classList.remove('table-warning');
                }, 2000);
            });

            // Remove "No data" row if it exists and we now have data
            const noDataRow = document.querySelector('#records_table tbody tr td[colspan="4"]');
            if (noDataRow && updatedItems.length > 0) {
                noDataRow.closest('tr').remove();
            }
        }

        function updateRow(row, item) {
            const brgElement = row.querySelector('#item-brg');
            const rakElement = row.querySelector('#item-rak');
            const sisaElement = row.querySelector('#item-sisa');

            if (brgElement) brgElement.textContent = item.brg;
            if (rakElement) rakElement.textContent = item.rak;
            if (sisaElement) sisaElement.textContent = item.sisa;

            // Jika elemen tidak ditemukan, kita bisa mempertimbangkan untuk membuat ulang seluruh baris
            if (!brgElement || !rakElement || !sisaElement) {
                console.warn(`Some elements missing for item ${item.id_brg}. Recreating row.`);
                const newRow = createNewRow(item);
                row.parentNode.replaceChild(newRow, row);
            }
        }

        function createNewRow(item) {
            console.log(item);
            const row = document.createElement('tr');
            row.id = 'item-row';
            row.setAttribute('data-id-brg', item.id_brg);
            row.setAttribute('data-id-rak', item.id_rak);

            row.innerHTML = `
                <td>
                    <div>
                        <h6 class="item-brg">${item.brg}</h6>
                    </div>
                </td>
                <td>
                    <h6 class="text-center item-rak">${item.rak}</h6>
                </td>
                <td>
                    <h6 class="text-center item-sisa">${item.sisa}</h6>
                </td>
            `;

            return row;
        }
    });
</script>