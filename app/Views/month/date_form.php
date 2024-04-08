<!-- MODAL -->
<?= $this->section('modal_title') ?>
Edit Date <span class="form-date-id-title"></span>
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<div class="row hidden">
    <div class="input-group timers_in_tmp">
        <span class="input-group-text">In</span>
        <input type="time" aria-label="in" class="form-control" name="in[]" step="1">
        <span class="col-1 btn delete-timer-row"><i class="bi bi-trash"></i></span>
    </div>
    <div class="input-group timers_out_tmp">
        <span class="input-group-text">Out</span>
        <input type="time" aria-label="out" class="form-control" name="out[]" step="1">
        <span class="col-1 btn delete-timer-row"><i class="bi bi-trash"></i></span>
    </div>
</div>
<form id="edit_date_form" method="post" action="<?= site_url('/month/edit_date') ?>">
    <?= csrf_field() ?>
    <input type="hidden" class="form-date-id" name="date_id">
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
    <div class="input-group mb-3">
        <label class="input-group-text" for="date-status">Status</label>
        <select class="form-select" aria-label="date-status" name="date_status">
            <option selected value="regular">regular</option>
            <option value="holiday">holiday</option>
            <option value="sickday">sickday</option>
        </select>
    </div>
    <div class="row">
        <div id="timers_feilds_in" class="col"></div>
        <div id="timers_feilds_out" class="col"></div>
    </div>
    <span class="btn btn-success plus_timer_row"><i class="bi bi-plus-circle"></i></span>
    <?= $this->endSection() ?>
    <!-- MODAL BUTTONS-->
    <?= $this->section('modal_buttons') ?>
    <button id="btn_add_user" type="submit" class="btn btn-success">Save</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <?= $this->endSection() ?>
</form>
<script>

</script>