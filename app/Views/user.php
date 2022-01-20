<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<header>
	<div class="heroe">
		<h1>Hello <?= $user['view_name'] ." you are ". $user['role'] ?></h1>
		<h2><?= $user['id'] ?></h2>
	</div>
</header>
<?= $this->endSection() ?>