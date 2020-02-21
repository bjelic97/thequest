<!-- Characters boxes section -->
<section class="characters-boxes-section">
	<div class="container">
		<!-- <div class="game-title">
			<img src="img/game-characters/title-icon.png" alt="">
			<h2>The Characters</h2>
		</div> -->
		<div class="row">
			<?php foreach ($games as $game) : ?>
				<div class="col-lg-3 col-sm-6">
					<div class="characters-box">
						<img src="<?= $game->src ?>" alt="<?= $game->alt ?>">
						<h4><?= $game->name ?></h4>
						<p><?php if (strlen($game->description) > 250) {
								echo substr($game->description, 0, 250) . ' ...';
							} else {
								echo $game->description;
							} ?></p>
						<a>Category : <?= strtoupper($game->categoryName) ?></a>
						<!-- <a href="index.php?page=games&id=<?= $game->id ?>" class="rm">See More</a> -->
					</div>
				</div>
			<?php endforeach; ?>


		</div>
	</div>
</section>
<!-- Characters boxes section end -->