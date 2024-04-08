<?php
$action = isset($user_edit) ? "/user/edit/$id" : '/register';
$button = isset($user_edit) ? 'Edit' : 'Register';
?>
<form id="new_user_form" method="post" action="<?= site_url($action) ?>">
    <?= csrf_field() ?>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="username" value="<?= isset($username) ? $username : '' ?>" required>
        <label for="username">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="view_name" name="view_name" placeholder="View Name" value="<?= isset($view_name) ? $view_name : '' ?>" required>
        <label for="view_name">View Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= isset($email) ? $email : '' ?>" required>
        <label for="email">Email address</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="company" name="company" placeholder="company" value="<?= isset($company) ? $company : '' ?>">
        <label for="company">Company</label>
    </div>
    <?php if (isset($can_delete) && $can_delete) : ?>
        <?= $this->include('/elements/role_selector') ?>
    <?php endif ?>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="password" value="" <?= isset($user_edit) ? '' : 'required' ?>>
        <label for="password">Password</label>
    </div>
    <button id="btn_add_user" type="submit" class="btn btn-success"><?= $button ?></button>
</form>