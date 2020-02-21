<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <input type="hidden" id="postId" value="<?= $post->id ?>" />
            <div class="col-lg-12 blog-posts">

                <div class="blog-post featured-post">



                    <?php if (isset($_SESSION['user'])) : ?>


                        <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                            <form id="upload-form" method="POST" enctype="multipart/form-data" action="index.php?page=posts&edit=img&id=<?= $post->id ?>">
                                <input type="button" value="&#xf0ad" class="btn btn-secondary upload-img-post fa fa-input" />
                                <label class="file">

                                    <input type="file" name="post-img" id="post-img" class="form-control-file  file elementDissapear">

                                </label>
                                <input type="submit" value="&#xf0c7" data-id="<?= $post->id ?>" id="save-upload-img" class="btn btn-primary bot fa fa-input save-img elementDissapear" />
                            </form>

                        <?php endif; ?>

                    <?php endif; ?>




                    <br />

                    <img id="original-img" src="<?= $post->src ?>" alt="<?= $post->alt ?>">


                    <div id="original-created-at" class="post-date"><?= $post->created_at ?></div>
                    <br />

                    <br />
                    <h3 id="show-title"><?= $post->title ?></h3>



                    <?php if (isset($_SESSION['user'])) : ?>


                        <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                            <input type="button" value="&#xf0ad" class="btn btn-outline-secondary title-post fa fa-input" />
                            <input type="button" value="&#xf0c7" id="save-title" class="btn btn-primary btnComm bot fa fa-input save-title elementDissapear" data-id="<?= $post->id ?>" />
                            <input id="field-title" class="form-control form-control-lg elementDissapear bot" type="text" placeholder="Title..">

                        <?php endif; ?>

                    <?php endif; ?>


                    <div class="post-metas">





                        <?php if (isset($_SESSION['user'])) : ?>


                            <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                                <input type="button" value="&#xf0ad" class="btn btn-outline-secondary users-post fa fa-input" />

                            <?php endif; ?>

                        <?php endif; ?>


                        <div id="users-original" class="post-meta btnComm"><i class="fa fa-user-secret" aria-hidden="true"></i> By <?= $post->username ?></div>



                        <?php if (isset($_SESSION['user'])) : ?>


                            <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                                <input type="button" value="&#xf0c7" id="save-users" class="btn btn-primary btnComm bot fa fa-input save-user elementDissapear" data-id="<?= $post->id ?>" />
                                <select id="ddl-users" class="form-control bot elementDissapear">
                                    <option value="0">Choose user..</option>
                                    <?php foreach ($users as $user) : ?>

                                        <option value="<?= $user->id ?>"><?= $user->firstname . " " . $user->lastname . " ( " . $user->username . " )" ?></option>
                                    <?php endforeach; ?>

                                </select>

                                <input type="button" value="&#xf0ad" class="btn btn-outline-secondary categories-post fa fa-input" data-id="<?= $post->id ?>" />

                            <?php endif; ?>

                        <?php endif; ?>



                        <div class="post-meta" id="categories-original"><i class="fa fa-gamepad" aria-hidden="true"></i> in <a href="#"><?= strtoupper($post->category) ?></a></div>





                        <input type="button" value="&#xf0c7" id="save-categories" data-id="<?= $post->id ?>" class="btn btn-primary btnComm bot btnComm fa fa-input save-category elementDissapear" />

                        <select id="ddl-categories" class="form-control elementDissapear bot">
                            <option value="0">Choose category..</option>
                            <?php foreach ($categories as $category) : ?>

                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>



                        <div class="post-meta"><?= $post->commNum ?> Comments</div>
                    </div>

                    <p id="original-content" class="word-wrap"><?= $post->content ?></p>


                    <?php if (isset($_SESSION['user'])) : ?>


                        <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                            <input type="button" value="&#xf0ad" id="edit" class="btn btn-outline-secondary content-post bot fa fa-input" />

                        <?php endif; ?>

                    <?php endif; ?>




                    <input type="button" value="&#xf0c7" id="save-content" class="btn btn-primary fa fa-input bot save-content elementDissapear" data-id="<?= $post->id ?>" />
                    <textarea class="form-control textareaPost elementDissapear bot" name="content" id="content" placeholder="Add content..."></textarea>
                    <br />

                    <p id="modified-at" style="float:right;"><i class="fa fa-cogs" aria-hidden="true"></i> Latest modify : <?= $post->modified_at ?></p>



                    <?php if (isset($_SESSION['user'])) : ?>


                        <?php if ($_SESSION['user']->id_user_role == 1) : ?>


                            <a href="#delete-modal" style="float:right;" class="trigger-btn btn btn-danger btn-lg btn-block delete-mod bot" data-id="<?= $post->id ?>" data-update="from-post" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete post</a>

                            <?php include "delete-modal.php" ?>

                        <?php endif; ?>

                    <?php endif; ?>


                </div>

                <?php include "comments.php" ?>
            </div>
        </div>
    </div>
</section>