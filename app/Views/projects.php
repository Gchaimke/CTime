<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<center>
    <div class="input-group mb-3">
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="awsome project">
            <label for="floatingInput">New Project Name</label>
        </div>
        <button class="btn btn-success action_btn" data-action="project_start"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
    </div>
</center>

<div class="content projects">

    <div class="row project-row">
        <span class="col project-name">Project name</span>
        <span class="col project-bnts">
            <button class="btn btn-success action_btn" data-action="project_in" data-project-id="">
                <i class="bi bi-play" style="font-size: 1.5rem;"></i>
            </button>
            <button class="btn btn-danger action_btn" data-action="project_out" data-project-id="" disabled>
                <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
            </button>
        </span>
    </div>
    <div class="row project-row">
        <span class="col project-name">Project name</span>
        <span class="col project-bnts">
            <button class="btn btn-success action_btn" data-action="project_in" data-project-id="">
                <i class="bi bi-play" style="font-size: 1.5rem;"></i>
            </button>
            <button class="btn btn-danger action_btn" data-action="project_out" data-project-id="" disabled>
                <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
            </button>
        </span>
    </div>
    <div class="row project-row">
        <span class="col project-name">Project name</span>
        <span class="col project-bnts">
            <button class="btn btn-success action_btn" data-action="project_in" data-project-id="">
                <i class="bi bi-play" style="font-size: 1.5rem;"></i>
            </button>
            <button class="btn btn-danger action_btn" data-action="project_out" data-project-id="" disabled>
                <i class="bi bi-stop" style="font-size: 1.5rem;"></i>
            </button>
        </span>
    </div>

</div>
<script>
    $(".action_btn").on("click", function() {
        let action = $(this).attr("data-action");
        $.post("/user/action", {
            action: action,
            csrf_test_name: "<?= csrf_hash() ?>",
        }).done(function(o) {
            location.reload();
        });
    });
</script>
<?= $this->endSection() ?>