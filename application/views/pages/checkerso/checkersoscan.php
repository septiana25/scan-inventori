<?php
$options = [
    'pack' => 'Koli/Karung/Dus',
    'pcs'  => 'Pcs'
];
?>
<main class="container">
    <section id="form">
        <?php $this->load->view('layouts/_alert') ?>
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
                        <tr>
                            <td>
                                <?php if (!$loadingShown): ?>
                                    <div id="loadingIndicator" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Sedang memproses...</p>
                                    </div>
                                    <?php $loadingShown = true; ?>
                                <?php endif; ?>
                                <div>
                                    <h6><?= $item->brg ?></h6>
                                    <div class="d-flex justify-content-between">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="text-center"><?= $item->sisa ?></h6>
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

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Form submitted');

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            console.log('Data to be sent:', data);

            if (loadingIndicator) {
                loadingIndicator.classList.remove('d-none');
            }

            fetch('<?= base_url("checkerso/save") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    console.log('Raw response:', response);
                    return response.json();
                })
                .then(result => {
                    console.log('Parsed response:', result);
                    // Proses respons di sini
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Tangani error di sini
                })
                .finally(() => {
                    if (loadingIndicator) {
                        loadingIndicator.classList.add('d-none');
                    }
                    form.reset();
                });
        });
    });
</script>