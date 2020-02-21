<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>


	<!-- Hero section -->
	<section class="hero-section">
		<div class="hero-slider owl-carousel">

			<?php foreach ($posts as $post) : ?>
				<div class="hero-item set-bg" data-setbg="app/assets/img/slider/1.jpg">
					<div class="container">
						<div class="row">
							<div class="col-lg-10 offset-lg-1">
								<h2><?= $post->title ?></h2>
								<p><?php if (strlen($post->content) > 300) {
										echo substr($post->content, 0, 300) . ' ...';
									} else {
										echo $post->content;
									} ?> </p>
								<a href="index.php?page=posts&id=<?= $post->id ?>" class="site-btn">Read More</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</section>
	<!-- Hero section end -->