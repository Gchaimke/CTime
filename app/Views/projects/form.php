<!-- MODAL -->
<?= $this->section('modal_title') ?>
Edit Project
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?= csrf_field() ?>
<div class="form-floating mb-3">
    <input type="hidden" class="form-project-id" name="project_id">
    <input type="text" class="form-control form-project-name" placeholder="project_name" required>
    <label for="project_name">Project Name</label>
</div>
<?= $this->endSection() ?>
<!-- MODAL BUTTONS-->
<?= $this->section('modal_buttons') ?>
<div class="btn btn-success btn_edit_project">Save</div>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

<?= $this->endSection() ?>
<script>
    $(document).on("click", ".edit-project", function() {
        $(".form-project-name").val($(this).attr("data-project-name"));
        $(".btn_edit_project").attr("data-project-id", $(this).attr("data-project-id"))
    });

    $(document).on("click", ".btn_edit_project",function() {
        let project_name = $(".form-project-name").val();
        if (project_name == "") {
            alert("Project name is empty");
        } else {
            $.post("<?= site_url('/projects/edit_project') ?>", {
                project_id: $(this).attr("data-project-id"),
                project_name: project_name,
                csrf_test_name: "<?= csrf_hash() ?>",
            }).done(function(o) {
                alert(o);
                location.reload();
            });
        }
    });
</script>