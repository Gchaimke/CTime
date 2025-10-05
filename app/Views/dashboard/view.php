<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<h1>Dashboard</h1>
<?= $this->include('/projects/form') ?>
<?= $this->include('/projects/list') ?>
<?= $this->endSection() ?>