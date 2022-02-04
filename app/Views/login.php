<?= $this->extend('/layouts/clean_layout') ?>
<?= $this->section('content') ?>
<style>
	html,
	body {
		height: 100%;
	}

	body {
		display: flex;
		align-items: center;
		padding-top: 40px;
		padding-bottom: 40px;
		background-color: #5b4695;
	}

	.form-signin {
		width: 100%;
		max-width: 400px;
		padding: 15px;
		margin: auto;
	}

	.form-signin .checkbox {
		font-weight: 400;
	}

	.form-signin .form-floating:focus-within {
		z-index: 2;
	}

	.form-signin input[type="email"] {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}

	.form-signin input[type="password"] {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}

	.login-form {
		padding: 20px;
		border-radius: 30px;
		background: #ababab66;
	}

	footer.footer.mt-auto.py-3.bg-light {
		background: #ffffff00 !important;
		position: absolute;
		bottom: 0;
		width: 100%;
	}
</style>
<main class="form-signin">
	<form class="login-form" method="post" action="<?= site_url('/login/try_login') ?>">
		<?= csrf_field() ?>
		<a href="<?= site_url('/') ?>"><?= img(array("src" => "public/assets/icons/clock-history.svg", "alt" => "Login", "class" => "mb-4", "width" => "172")) ?></a>
		<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

		<div class="form-floating">
			<input type="teax" class="form-control mb-2" name="username" id="floatingInput" placeholder="Username" required>
			<label for="floatingInput">User Name</label>
		</div>
		<div class="form-floating">
			<input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
			<label for="floatingPassword">Password</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		<p class="mt-5 mb-3 mt-5 mb-3 text-white">CTime© V<?= APP_VARSION ?> &nbsp; 2021–<?= date("Y") ?></p>
	</form>
</main>
<?= $this->endSection() ?>