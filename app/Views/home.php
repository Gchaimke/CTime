<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<center>
    <?php if ($last_action["action"] == "none") : ?>
        <h2>To start click "IN"</h2>
        <?=$last_action["time"]?>
    <?php else : ?>
        <h2><?= "Today last action is: {$last_action["action"]}, at {$last_action["time"]}" ?></h2>
    <?php endif ?>

    <p><?= $time ?></p>
    <?php if ($last_action["action"] == "in") : ?>
        <button class="btn btn-success action_btn" data-action="in" disabled><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
        <button class="btn btn-danger action_btn" data-action="out"><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
    <?php else : ?>
        <button class="btn btn-success action_btn" data-action="in"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
        <button class="btn btn-danger action_btn" data-action="out" disabled><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
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