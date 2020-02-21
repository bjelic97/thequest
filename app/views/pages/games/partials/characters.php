

<!-- Characters boxes section -->
<section class="characters-boxes-section">
	<div class="container">
		<div class="game-title">
			<img src="img/game-characters/title-icon.png" alt="">
			<h2>The Characters</h2>
		</div>
		<div class="row">

			<div class="col-lg-3 col-sm-6">
				<div class="characters-box">
					<img src="img/characters-boxes/1.jpg" alt="">
					<h4><?=$game->name?></h4>
					<p><?=$game->description?></p>
					<a href="index.php?page=games&id=<?=$game->id?>" class="rm">See More</a>
				</div>
			</div>


		</div>
	</div>
</section>
<!-- Characters boxes section end -->