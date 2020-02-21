<!-- Blog section -->
<section class="blog-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 blog-posts">

				<?php if (isset($_SESSION['user'])) : ?>


					<?php if ($_SESSION['user']->id_user_role == 1) : ?>
						<div class="row">
							<div class="col-md-12">
								<a href="index.php?page=posts&id=new" class="btn btn-dark btn-lg btn-block"><i class="fa fa-plus" aria-hidden="true"></i> New post</a>
							</div>
						</div>

					<?php endif; ?>


				<?php endif; ?>


				<div class="row" id="posts">

					<?php foreach ($posts as $post) : ?>

						<div class="col-md-6">
							<?php if (isset($_SESSION['user'])) : ?>


								<?php if ($_SESSION['user']->id_user_role == 1) : ?>
									<a href="index.php?page=posts&id=<?= $post->id ?>" class="btn btn-secondary btnComm"><i class="fa fa-wrench" aria-hidden="true"></i></a>
									<a href="#delete-modal" style="float:right;" class="trigger-btn btn btn-danger btnComm delete-mod" data-id="<?= $post->id ?>" data-update="from-posts" data-toggle="modal"><i class="fa fa-times" aria-hidden="true"></i></a>

									<?php include "partials/delete-modal.php" ?>
								<?php endif; ?>


							<?php endif; ?>

							<div class="blog-post">
								<img src="<?= $post->src_small ?>" alt="<?= $post->alt ?>">
								<div class="post-date"><?= $post->created_at ?>

								</div>

								<h4><?= $post->title ?></h4>
								<div class="post-metas">
									<div class="post-meta">By <i class="fa fa-user-secret" aria-hidden="true"></i> <a><?= $post->firstname . ' ' . $post->lastname ?></a></div>
									<div class="post-meta"><i class="fa fa-gamepad" aria-hidden="true"></i> in <a> <?= strtoupper($post->category) ?></a></div>
									<div class="post-meta"><i class="fa fa-comments" aria-hidden="true"></i> <?= $post->commNum ?> Comments</div>
								</div>
								<p class="word-wrap"><?php if (strlen($post->content) > 300) {
															echo substr($post->content, 0, 300) . ' ...';
														} else {
															echo $post->content;
														} ?></p>
								<a href="index.php?page=posts&id=<?= $post->id ?>" class="read-more">Read More</a>

							</div>
						</div>

					<?php endforeach; ?>

				</div>
				<div>
					<?php include "partials/paginator.php" ?>
				</div>
			</div>
			<?php
			include  "partials/categories.php";
			?>
		</div>
	</div>
	</div>
</section>




<!-- Blog section end -->