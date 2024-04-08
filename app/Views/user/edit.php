<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4 mb-5">
    <?= $this->include('/user/form') ?>
</div>
<?= $this->endSection() ?>