<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<h1>Admin</h1>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="true"><i class="bi bi-people"></i></button>
        <button class="nav-link" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="false"><i class="bi bi-nut"></i></button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
        <div class="container mt-5">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-person-plus"></i>
            </button>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">View Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php
                foreach ($users as $f_user) {
                    echo "<tr id='$f_user->id'><th scope='row'>$f_user->username</th>";
                    echo "<td>$f_user->view_name</td>";
                    echo "<td>$f_user->role</td>";
                    echo "<td><div class='btn btn-info m-2'><i class='bi bi-pencil-square'></i></div>";
                    if ($user['username'] != $f_user->username) {
                        echo "<div class='btn btn-danger m-2 delete_user'><i class='bi bi-trash'></i></div>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>

        </div>
    </div>
    <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">...</div>
</div>

<!-- MODAL -->

<?= $this->section('modal_content') ?>
<form id="new_user_form" method="post" action="/user/register">
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

    <!-- MODAL TITLE-->
    <?= $this->section('modal_title') ?>
    Add User
    <?= $this->endSection() ?>
</form>
<script>
    $(".delete_user").on("click", function() {
        let user_id = $(this).closest('tr').attr('id');
        $.post("/user/delete", {
            id: user_id,
            csrf_test_name: "<?= csrf_hash() ?>",
        }).done(function(o) {
            location.reload();
            // console.log(o);
        });
    });
</script>
<?= $this->endSection() ?>