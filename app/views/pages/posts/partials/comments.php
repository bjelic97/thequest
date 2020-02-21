<!-- COMMENTS SECTION-->

<div class="sb-widget">
    <h2 class="sb-title">Latest Comments</h2>
    <div class="latest-comments-widget" id="comments">

        <?php foreach ($comments as $comment) : ?>

            <div class="lc-item">
                <img src="app/assets/img/author-thumbs/1.jpg" alt="">
                <div class="lc-text">
                    <h6><?= $comment->username ?><span> In </span><a href=""><?= $post->title ?></a></h6>
                    <input type="button" value="&#xf2d3 Close" id="close-<?= $comment->id ?>" class=" btn btn-warning btnComm fa fa-input close-edit elementDissapear" data-id="<?= $comment->id ?>" />
                    <input type="button" value="&#xf0c7 Save" id="save-<?= $comment->id ?>" class="btn btn-primary btnComm fa fa-input save-edit elementDissapear" data-id="<?= $comment->id ?>" />
                    <p id="comment-<?= $comment->id ?>" class="bot"><?= $comment->content ?></p>
                    <textarea id="field-<?= $comment->id ?>" class=" form-control textarea elementDissapear" name="editComment" rows="4" cols="2"><?= $comment->content ?></textarea>
                    <div class="lc-date">Created : <?= $comment->created_at ?></div>
                    <div id="modified-at-comm-<?= $comment->id ?>" class="lc-date">Modified : <?= $comment->modified_at ?></div>
                    <?php if (isset($_SESSION['user'])) : ?>

                        <?php if ($_SESSION['user']->id == $comment->created_by) : ?>

                            <input type="button" value="&#xf0ad" id="edit" class="btn btn-secondary btnComm fa fa-input edit-comment" data-id="<?= $comment->id ?>" />

                        <?php endif; ?>

                        <?php if (($_SESSION['user']->id == $comment->created_by) || ($_SESSION['user']->id_user_role == 1)) : ?>

                            <input type="button" value="&#xf00d" id="remove" class="btn btn-danger btnComm fa fa-input remove-comment" data-id="<?= $comment->id ?>" />

                        <?php endif; ?>



                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>

        <?php if (isset($_SESSION['user'])) : ?>


            <div class="lc-item">
                <img src="app/assets/img/author-thumbs/1.jpg" alt="">
                <div class="lc-text">
                    <h6><?= $_SESSION['user']->username ?><span> In </span><a href=""><?= $post->title ?></a></h6>
                    <form class="comment-form">
                        <input type="hidden" id="hdnId" />
                        <div class="row">
                            <div class="col-md-6">
                                <textarea class="form-control textarea bot" name="comment" id="comment" rows="4" cols="2" placeholder="Add comment..."></textarea>
                            </div>
                            <div class="col-md-1">
                                <input type="button" value="&#xf067" id="saveComment" class="btn btn-primary btnComm fa fa-input" />
                            </div>
                            <div class="col-md-5">

                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>