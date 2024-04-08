<?= $this->extend('/layouts/clean_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4 mb-5">
    <?= $this->include('/user/user_form') ?>
</div>
<?= $this->endSection() ?>