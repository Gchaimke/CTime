<div class="modal fade" id="staticBackdrop"   aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $this->renderSection('modal_title') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $this->renderSection('modal_content') ?>
            </div>
            <div class="modal-footer">
                <?= $this->renderSection('modal_buttons') ?>
            </div>
        </div>
    </div>
</div>