<!-- MODAL -->
<?= $this->section('modal_title') ?>
Edit Project
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<form id="edit_project_form" method="post" action="<?= site_url('/projects/edit_project/') ?>">
    <?= csrf_field() ?>
    <div class="form-floating mb-3">
        <input type="hidden" class="form-project-id" name="project_id">
        <input type="text" class="form-control form-project-name" name="project_name" placeholder="project_name" required>
        <label for="project_name">Project Name</label>
    </div>
    <?= $this->endSection() ?>
    <!-- MODAL BUTTONS-->
    <?= $this->section('modal_buttons') ?>
    <button id="btn_add_user" type="submit" class="btn btn-success">Save</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</form>
<?= $this->endSection() ?>
<script>

</script>