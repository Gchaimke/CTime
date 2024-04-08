<div class="input-group my-2">
    <div class="form-floating flex-fill">
        <input type="date" class="form-control" id="new_date">
        <label class="text-nowrap" for="new_date">Add new date</label>
    </div>
    <button class="btn btn-success add_new_date"><i class="bi bi-plus-circle"></i></button>
</div>
<script>
    $(".add_new_date").on("click", function() {
        let date = $("#new_date").val();
        if (date == "") {
            alert("Please select date");
        } else {
            $.post("<?= site_url('/month/add_date') ?>", {
                date: date,
                user_id: "<?= $user["id"] ?>",
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                alert(o);
                location.reload();
            });
        }
    });
</script>