<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<?php
$in = "";
$out = "";
if ($last_action["action"] == "in") {
    $in = "disabled";
} else {
    $out = "disabled";
}

?>
<center>
    <?php if ($last_action["action"] == "none") : ?>
        <h2>Click <i class="bi bi-play" style="font-size: 1.5rem;"></i> to start.</h2>
        <button class="btn btn-warning action_btn mb-3" data-action="holiday">Holiday</button>
        <button class="btn btn-dark action_btn mb-3" data-action="sickday">Sickday</button><br>
    <?php else : ?>
        <h2><?= "Today {$last_action["action"]} {$last_action["time"]}" ?></h2>
    <?php endif ?>
    <?php if ($last_action["action"] != "holiday" && $last_action["action"] != "sickday") : ?>
        <button class="btn btn-success action_btn" data-action="in" <?= $in ?>><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
        <button class="btn btn-danger action_btn" data-action="out" <?= $out ?>><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
    <?php endif ?>
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