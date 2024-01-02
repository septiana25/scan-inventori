<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Scan APP' ?> </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- <script src="assets/js/<?= $filejs[1]; ?>.js"></script> -->

</body>

</html>