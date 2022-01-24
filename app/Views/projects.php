<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<center>

    <div class="input-group mb-3 ">
        <div class="form-floating w-75">
            <input type="text" class="form-control" id="floatingInput" placeholder="awsome project">
            <label for="floatingInput">New Project Name</label>
        </div>
        <button class="btn btn-success action_btn" data-action="in"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
    </div>


    <div class="input-group">
        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username with two button addons">
        <button class="btn btn-success action_btn" data-action="in"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
        <button class="btn btn-danger action_btn" data-action="out" disabled><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
    </div>

</center>
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