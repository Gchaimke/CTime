<?= $this->extend('/layouts/default_layout') ?>
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
                    echo "<td><a class='btn btn-info m-2' href='/user/edit/$f_user->id'><i class='bi bi-pencil-square'></i></a>";
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

<?= $this->include('/elements/user_form_modal') ?>

<script>
    $(".delete_user").on("click", function() {
        let user_id = $(this).closest('tr').attr('id');
        $.post("<?= site_url('/user/delete') ?>", {
            id: user_id,
            csrf_test_name: "<?= csrf_hash() ?>",
        }).done(function(o) {
            location.reload();
            // console.log(o);
        });
    });
</script>
<?= $this->endSection() ?>