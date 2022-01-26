<!-- MODAL -->
<?= $this->section('modal_title') ?>
Add User
<?= $this->endSection() ?>


<?= $this->section('modal_content') ?>
<form id="new_user_form" method="post" action="<?= site_url('/user/register') ?>">
    <?= csrf_field() ?>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
        <label for="username">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="view_name" name="view_name" placeholder="View Name" required>
        <label for="view_name">View Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
        <label for="email">Email address</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="company" name="company" placeholder="company" required>
        <label for="company">Company</label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" id="role" name="role" aria-label="Select Role" required>
            <option selected>Role</option>
            <option value="user">User</option>
            <option value="manager">Manager</option>
            <option value="admin">Admin</option>
        </select>
        <label for="floatingSelect">Select Role</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="password" required>
        <label for="password">Password</label>
    </div>
    <?= $this->endSection() ?>

    <!-- MODAL BUTTONS-->
    <?= $this->section('modal_buttons') ?>
    <button id="btn_add_user" type="submit" class="btn btn-success">Add User</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <?= $this->endSection() ?>
</form>