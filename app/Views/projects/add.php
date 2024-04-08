<div class="d-flex" style="align-items: center;">
    <?= csrf_field() ?>
    <div class="input-group mb-2 ">
        <div class="form-floating flex-fill">
            <input type="text" id="project_name" class="form-control" placeholder="">
            <label for="project_name">New Project Name</label>
        </div>
        <button class="btn btn-success btn_add_project"><i class="bi bi-plus-circle" style="font-size: 1.5rem;"></i></button>
    </div>
</div>

<script>
    $(".btn_add_project").on("click", function() {
        let project_id = $(this).attr("data-project-id");
        let project_name = $("#project_name").val();
        if (project_name == "") {
            alert("Project name is epmty");
        } else {
            $.post("<?= site_url('/projects/add_project') ?>", {
                project_name: project_name,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                alert(o);
                location.reload();
            });
        }
    });
</script>