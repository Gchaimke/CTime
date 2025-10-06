<!-- MODAL -->
<?= $this->section('modal_title') ?>
Edit Project
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?= csrf_field() ?>
<form id="project_edit_form" method="post" action="<?= site_url("/projects/edit_project") ?>">
    <input type="hidden" class="form-project-id" name="project_id">
    <div class="form-floating mb-3">
        <input name="project_name" type="text" class="form-control form-project-name" required>
        <label>Project Name</label>
    </div>
    <div class="form-floating mb-3">
        <input name="per_hour" type="text" class="form-control form-per-hour" required>
        <label>Per Hour</label>
    </div>
    <div class="form-floating mb-3">
        <select name="currency" class="form-control form-currency" required>
            <?php foreach (CURRENCIES as $code => $currency): ?>
                <option value="<?= $code ?>"><?= $currency['title'] ?> (<?= $currency['symbol'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <label>Currency</label>
    </div>
    <?= $this->endSection() ?>
    <!-- MODAL BUTTONS-->
    <?= $this->section('modal_buttons') ?>
    <button type="submit" class="btn btn-success btn_edit_project">Save</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</form>

<?= $this->endSection() ?>
<script>
    $(document).on("click", ".edit-project", function() {
        $(".form-project-name").val($(this).attr("data-project-name"));
        $(".form-project-id").val($(this).attr("data-project-id"));
        $(".form-per-hour").val($(this).attr("data-project-per-hour"));
        $(".form-currency").val($(this).attr("data-project-currency"));
        $(".btn_edit_project").attr("data-project-id", $(this).attr("data-project-id"))
    });

    $(document).on("submit", "#project_edit_form",function(event) {
        event.preventDefault();
        $.post("<?= site_url('/projects/edit_project') ?>", {
            form : $(this).serialize(),
            csrf_test_name: "<?= csrf_hash() ?>",
        }).done(function(o) {
            alert(o);
            location.reload();
        });
    });
</script>