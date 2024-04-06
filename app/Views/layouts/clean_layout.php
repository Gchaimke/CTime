<?php
$display_message = "none";
if (session()->getFlashdata('error') != "" || service('validation')->getErrors() || $message_text != "") {
    $display_message = "block";
}

?>
<!DOCTYPE html>
<html lang="en">
<?= $this->include('/layouts/head') ?>

<div class="alert alert-<?= $message_type ?> messages" style="display:<?= $display_message ?>;">
    <?= session()->getFlashdata('error') ?>
    <?= service('validation')->listErrors() ?>
    <?= $message_text ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<body class="text-center">
    <?= $this->renderSection('content') ?>
    <?= $this->include('/layouts/footer') ?>
</body>

</html>