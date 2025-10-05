<?php if ($projects) : ?>
    <?php foreach ($projects as $project) : ?>
        <?php
        $in = "";
        $out = "";
        $active = "";
        $total = convertToHoursMins($project->total, "%02d:%02d:%02d");
        if ($project->is_started) {
            $in = "hidden";
            $active = "active";
        } else {
            $out = "hidden";
        } ?>
        <div class="row project-row <?= $active ?>">
            <span class="col btn edit-project" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-project-id="<?= $project->id ?>" data-project-name="<?= $project->project_name ?>">
                <i class="bi bi-pencil-square"></i>
            </span>
            <span class="col project-name edit-mode"><?= $project->project_name ?></span>
            <span class="col view_timers"></span>
            <span class="col-md-3 col-sm-12">Total: <span class=" total-time<?= $active ?>"><?= $total  ?></span></span>
            <span class="col-md-4 col-sm-12">
                <div class='input-group'>
                    <span class="input-group-text">Paid Hours</span>
                    <input type='number' class='form-control total-payed' data-project-id='<?= $project->id ?>' value='<?= @$project->total_payed ?? 0 ?>'>
                </div>
            </span>
            <span class="col btn view_timers"><i class="bi bi-list-ul"></i></span>
            <span class="col project-bnts">
                <button class="btn btn-success action_btn mx-1 my-1 <?= $in ?>" data-action="in" data-project-id="<?= $project->id ?>">
                    <i class="bi bi-play" style="font-size: 1.5rem;"></i>
                </button>
                <button class="btn btn-danger action_btn mx-1 my-1 <?= $out ?>" data-action="out" data-project-id="<?= $project->id ?>">
                    <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
                </button>
            </span>
            <span class="col btn delete-project" data-project-id="<?= $project->id ?>" data-project-name="<?= $project->project_name ?>"><i class="bi bi-trash"></i></span>
            <div class="project_timers hidden">
                <?php foreach ($project->timers as $id => $timer): ?>
                    <div class='row timer-row'>
                        <div class='col-md-4'>
                            <div class='input-group mb-3'>
                                <span class="input-group-text">In</span>
                                <input type='text' class='form-control timer-in' data-timer-id='<?= $id ?>'
                                    data-project-id='<?= $project->id ?>' value='<?php echo date("Y-m-d H:i:s", strtotime($timer->in)); ?>'>
                            </div>
                        </div>
                        <?php if (isset($timer->out)): ?>
                            <div class='col-md-4'>
                                <div class='input-group mb-3'>
                                    <span class="input-group-text">Out</span>
                                    <input type='text' class='form-control timer-out' data-timer-id='<?= $id ?>'
                                        data-project-id='<?= $project->id ?>' value='<?php echo date("Y-m-d H:i:s", strtotime($timer->out)); ?>'>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='input-group mb-3'>
                                    <?php $sub_total = (strtotime($timer->out) - strtotime($timer->in)) / 60; ?>
                                    <?php if ($sub_total < 0) $sub_total = (24 * 60) - abs($sub_total); ?>
                                    <span class="input-group-text">Total <?php echo convertToHoursMins($sub_total, "%02d:%02d:%02d"); ?></span>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='input-group mb-3'>
                                    <span class="btn btn-danger delete-timer" data-timer-id='<?= $id ?>' data-project-id='<?= $project->id ?>' data-project-name='<?= $project->project_name ?>'><i class="bi bi-trash"></i></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class='col'>
                                <div class='input-group mb-3'>
                                    <span class="input-group-text">Out</span>
                                    <input type='text' class='form-control' value='-- -- --' readonly>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='input-group mb-3'>
                                    <span class="input-group-text">Total -- -- --</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
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
            alert("Project name is empty");
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

    $(".total-payed").on("change", function() {
        let project_id = $(this).attr("data-project-id");
        let new_value = $(this).val();
        $.post("<?= site_url('/projects/update_total_payed') ?>", {
            project_id: project_id,
            new_value: new_value,
            csrf_test_name: "<?= csrf_hash() ?>",
        }).done(function(o) {
            if (o.includes("Error")) {
                alert(o);
            }
            // location.reload();
        });
    });

    $('.edit-mode').on("click", function() {
        $(".edit-project").toggle();
        $(".delete-project").toggle();
    });

    $('.view_timers').on("click", function() {
        $(this).closest('.project-row').children('.project_timers').toggle();
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

    $(".delete-timer").on("click", function() {
        let timer_row = $(this).closest('.timer-row');
        let project_id = $(this).attr("data-project-id");
        let project_name = $(this).attr("data-project-name");
        let timer_id = $(this).attr("data-timer-id");
        let is_confirmed = confirm(`Delete timer "${timer_id}" from project "${project_name}"?`);
        if (is_confirmed) {
            $.post("<?= site_url('/projects/delete_timer') ?>", {
                project_id: project_id,
                timer_id: timer_id,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                if (o.includes("Error")) {
                    alert(o);
                } else {
                    timer_row.remove();
                }
            });
        }
    });

    $(".timer-in").on("change", function() {
        updateTimer($(this), "in");
    });

    $(".timer-out").on("change", function() {
        updateTimer($(this), "out");
    });

    function updateTimer(thisElement, action) {
        let project_id = thisElement.attr("data-project-id");
        let timer_id = thisElement.attr("data-timer-id");
        let new_value = thisElement.val();
        // let is_confirmed = confirm(`Change timer "${timer_id}" ${action} to ${new_value}?`);
        let is_confirmed = true;
        if (is_confirmed) {
            $.post("<?= site_url('/projects/change_timer') ?>", {
                project_id: project_id,
                timer_id: timer_id,
                action: action,
                new_value: new_value,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                if (o.includes("Error")) {
                    alert(o);
                }
            });

        }

    }
</script>