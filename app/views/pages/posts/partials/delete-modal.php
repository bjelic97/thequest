<!-- Modal HTML -->
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-sm-1 btnComm">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-10">
                        <h4 class="modal-title">Confirm action</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this post? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info cancel-mod" data-dismiss="modal">Cancel</button>
                <a href="#" class="trigger-btn btn btn-danger delete-post" data-dismiss="modal" data-update="" data-id="<?= $post->id ?>">Delete</a>
                <div id="spinner" class="spinner-border elementDissapear" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>