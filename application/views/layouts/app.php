<?php
function asset_url($filename)
{
    $version = filemtime(FCPATH . 'assets/' . $filename);
    return base_url('assets/' . $filename) . '?v=' . $version;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Scan APP' ?> </title>
    <link rel="stylesheet" href="<?= asset_url('css/w3.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/raleway.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/style.css') ?>">
    <!-- jQuery library -->
    <script src="<?= asset_url('js/jquery.min.js') ?>"></script>
    <script src="<?= asset_url('js/loadingIndicator.js') ?>"></script>
    <script src="<?= asset_url('js/alertManager.js') ?>"></script>
</head>

<body>
    <div id="container">
        <header>
            <nav>
                <h3 class="text-center"><?= isset($nav) ? $nav : 'Scan APP' ?></h3>
            </nav>
        </header>

        <!-- Content -->
        <?php
        $this->load->view($page);
        $filejs = explode("/", $page);
        //var_dump($input);


        ?>
        <!-- End Content -->

        <!-- Footer -->
        <?php $this->load->view('layouts/_footer'); ?>
        <!-- Endfoofter -->

    </div>
    <script>
        $(document).ready(function() {

            function showAlertAndRemove(alertClass) {
                $(alertClass).delay(500).show(10, function() {
                    $(this).delay(2000).hide(10, function() {
                        $(this).remove();
                    });
                });
            }

            showAlertAndRemove(".alert-success");
            showAlertAndRemove(".alert-danger");

        });
    </script>
    <script src="<?= asset_url('js/popper.min.js') ?>"></script>
    <script src="<?= asset_url('js/bootstrap.bundle.min.js') ?>"></script>

    <!-- <script src="assets/js/<?= $filejs[1]; ?>.js"></script> -->

</body>

</html>