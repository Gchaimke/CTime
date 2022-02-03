<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<div class="row" style="align-items: center;">
    <div class="col-md input-group mb-2">
        <div class="form-floating col-10">
            <input type="text" class="form-control" id="project_name" placeholder="awsome project">
            <label for="project_name">New Project Name</label>
        </div>
        <button class="btn btn-success action_btn" data-action="new_project"><i class="bi bi-plus-circle" style="font-size: 1.5rem;"></i></button>
    </div>
    <div class="col text-end m-3">
        <button class="btn btn-info edit-mode"><i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i></button>
    </div>
</div>
<?php if ($projects) : ?>
    <?php foreach ($projects as $project) : ?>
        <?php
        $in = "";
        $out = "";
        $active = "";
        $total = $project->total;
        if ($project->is_started) {
            $in = "hidden";
            $active = "active";
            $total = convertToHoursMins($active_project_time, "%02d:%02d:%02d");
        } else {
            $out = "hidden";
            $total = convertToHoursMins($project->total);
        } ?>
        <div class="row project-row <?= $active ?>">
            <span class="col-1 btn edit-project" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-project-id="<?= $project->id ?>" data-project-name="<?= $project->project_name ?>">
                <i class="bi bi-pencil-square"></i>
            </span>
            <span class="col project-name"><?= $project->project_name ?></span>
            <span class="col">Total: <span class=" total-time<?= $active ?>"><?= $total  ?></span></span>
            <span class="col project-bnts">
                <button class="btn btn-success action_btn mx-1 my-1 <?= $in ?>" data-action="in" data-project-id="<?= $project->id ?>">
                    <i class="bi bi-play" style="font-size: 1.5rem;"></i>
                </button>
                <button class="btn btn-danger action_btn mx-1 my-1 <?= $out ?>" data-action="out" data-project-id="<?= $project->id ?>">
                    <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
                </button>
            </span>
            <span class="col-1 btn delete-project" data-project-id="<?= $project->id ?>" data-project-name="<?= $project->project_name ?>"><i class="bi bi-trash"></i></span>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?= $this->include('/elements/project_form') ?>
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
            $.post("<?= site_url('/projects/action_project') ?>", {
                action: action,
                project_id: project_id,
                project_name: project_name,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                if (o.includes("Error")) {
                    alert(o);
                }
                location.reload();
            });
        }
    });

    $('.edit-mode').on("click", function() {
        $(".edit-project").toggle();
        $(".delete-project").toggle();
    });

    $(document).on("click", ".edit-project", function() {
        let project_id = $(this).attr("data-project-id");
        let project_name = $(this).attr("data-project-name");
        $(".form-project-name").val(project_name);
        $(".form-project-id").val(project_id);
    });

    $(".delete-project").on("click", function() {
        let project_id = $(this).attr("data-project-id");
        let project_name = $(this).attr("data-project-name");
        let is_confirmed = confirm(`Delete project "${project_name}"?`);
        if (is_confirmed) {
            $.post("<?= site_url('/projects/delete') ?>", {
                id: project_id,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                if (o.includes("Error")) {
                    alert(o);
                }
                location.reload();
            });
        }
    });
</script>
<?= $this->endSection() ?>