<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Scan APP' ?> </title>
    <link rel="stylesheet" href="<?= base_url('assets/css/w3.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/raleway.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <!-- jQuery library -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
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
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- <script src="assets/js/<?= $filejs[1]; ?>.js"></script> -->

</body>

</html>