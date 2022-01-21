<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<h1>Home <?= CodeIgniter\CodeIgniter::CI_VERSION ?></h1>
<?php if ($last_action["action"] == "none") : ?>
    <h2>To start click "IN"</h2>
<?php else : ?>
    <h2><?= "Today last action is: {$last_action["action"]}, at {$last_action["time"]}" ?></h2>
<?php endif ?>

<?php if ($last_action["action"] == "in") : ?>
    <button class="btn btn-danger action_btn" data-action="out">OUT</button>
<?php else : ?>
    <button class="btn btn-success action_btn" data-action="in">IN</button>
<?php endif ?>

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