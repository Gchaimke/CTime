<div class="form-floating mb-3">
    <select class="form-select" id="role" name="role" aria-label="Select Role">
        <?php foreach (ROLES as $key => $value) : ?>
            <option value="<?= $key ?>" <?= isset($role) && $role == $key ? 'selected' : '' ?>><?=$value['title']?></option>
        <?php endforeach ?>
    </select>
    <label for="floatingSelect">Select Role</label>
</div>