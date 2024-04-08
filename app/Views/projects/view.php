<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<?= $this->include('/projects/add') ?>

<?= $this->include('/projects/form') ?>
<?= $this->include('/projects/list') ?>
<?= $this->endSection() ?>