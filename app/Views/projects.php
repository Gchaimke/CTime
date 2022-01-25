<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<center>
    <div class="input-group mb-3">
        <div class="form-floating">
            <input type="text" class="form-control" id="project_name" placeholder="awsome project">
            <label for="project_name">New Project Name</label>
        </div>
        <button class="btn btn-success action_btn" data-action="project_start"><i class="bi bi-plus-circle" style="font-size: 1.5rem;"></i></button>
    </div>
</center>
<?php if ($projects) : ?>

    <div class="content projects">
        <?php foreach ($projects as $project) : ?>

            <div class="row project-row">
                <span class="col project-name"><?= $project->project_name ?></span>
                <span class="col project-bnts">
                    <button class="btn btn-success action_btn" data-action="project_in" data-project-id="<?= $project->id ?>">
                        <i class="bi bi-play" style="font-size: 1.5rem;"></i>
                    </button>
                    <button class="btn btn-danger action_btn" data-action="project_out" data-project-id="<?= $project->id ?>" disabled>
                        <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
                    </button>
                </span>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
<script>
    $(".action_btn").on("click", function() {
        let action = $(this).attr("data-action");
        let project_id = $(this).attr("data-project-id");
        if (project_id == undefined) {
            project_id = "";
        }
        let project_name = $("#project_name").val();
        if (project_id == "" && project_name == "") {
            alert("Project name is epmty");
        } else {
            $.post("/user/action_project", {
                action: action,
                project_id: project_id,
                project_name: project_name,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                if (o == "error") {
                    alert("Error");
                }
                location.reload();
            });
        }
    });
</script>
<?= $this->endSection() ?>