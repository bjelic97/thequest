  <!-- Game section -->
  <section class="game-section character-one">
  	<div class="container">
  		<div class="row">
  			<div class="col-lg-7">
  				<div class="about-game">
  					<div class="game-title mb-0">
  						<img src="img/game-characters/title-icon.png" alt="">
  						<h2><?= $game->name ?></h2>
  					</div>
  					<div class="rating">
  						<i class="fa fa-star"></i>
  						<i class="fa fa-star"></i>
  						<i class="fa fa-star"></i>
  						<i class="fa fa-star"></i>
  						<i class="fa fa-star"></i>
  					</div>
  					<p><?php if (strlen($game->description) > 300) {
								echo substr($game->description, 0, 300) . ' ...';
							} else {
								echo $game->description;
							} ?></p>
  					<!-- <div class="site-btn">Read More</div> -->
  				</div>
  			</div>
  			<div class="col-lg-5">
  				<div class="about-game-img">
  					<img src="img/game-characters/5.png" alt="">
  				</div>
  			</div>
  		</div>
  	</div>
  </section>
  <!-- Game section end -->