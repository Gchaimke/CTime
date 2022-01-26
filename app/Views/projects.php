<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<div class="row" style="align-items: center;">
    <div class="col input-group mb-3">
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
            $in = "disabled";
            $active = "active";
            $total = convertToHoursMins($active_project_time, "%02d:%02d:%02d");
        } else {
            $out = "disabled";
            $total = convertToHoursMins($project->total);
        } ?>
        <div class="row project-row <?= $active ?>">
            <span id="<?= $project->id ?>" class="col-1 btn edit-project"><i class="bi bi-pencil-square"></i></span>
            <span class="col project-name"><?= $project->project_name ?></span>
            <span class="col">Total: <span class=" total-time<?= $active ?>"><?= $total  ?></span></span>
            <span class="col project-bnts">
                <button class="btn btn-success action_btn mx-1 my-1" data-action="in" data-project-id="<?= $project->id ?>" <?= $in ?>>
                    <i class="bi bi-play" style="font-size: 1.5rem;"></i>
                </button>
                <button class="btn btn-danger action_btn mx-1 my-1" data-action="out" data-project-id="<?= $project->id ?>" <?= $out ?>>
                    <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
                </button>
            </span>
        </div>
    <?php endforeach ?>
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
            $.post("<?= site_url('/user/action_project') ?>", {
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
    })
</script>
<?= $this->endSection() ?>