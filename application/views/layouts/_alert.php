<?php
$success = $this->session->flashdata('success');
$error = $this->session->flashdata('error');
$warning = $this->session->flashdata('warning');

if ($success) {
    $alert_status  = 'alert-success';
    $status        = 'Success';
    $message       = $success;
}

if ($error) {
    $alert_status  = 'alert-danger';
    $status        = 'Error';
    $message       = $error;
}

if ($warning) {
    $alert_status  = 'alert-warning';
    $status        = 'Warning';
    $message       = $warning;
}

if ($success || $error || $warning) :
?>

    <div class="alert <?= $alert_status ?> alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 mt-md-5" role="alert" style="z-index: 9999;">
        <strong><?= $status ?></strong> <?= $message ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php endif ?>