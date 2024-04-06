<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4 mb-5">
    <?= $this->include('/elements/user_form') ?>
</div>
<?= $this->endSection() ?>