  <div class="col-lg-4 sidebar">
  	<div class="sb-widget">
  		<form class="sb-search">
  			<input type="text" id="filter" placeholder="Search by title">
  		</form>
  	</div>

  	<div class="sb-widget">

  		<select class="form-control" id="sort">
  			<option value="0">Order by..</option>
  			<?php

				$options = [
					[
						"value" => 1,
						"text" => "Title - Ascending"
					],
					[
						"value" => 2,
						"text" => "Title - Descending"
					],
					[
						"value" => 3,
						"text" => "Latest"
					],
					[
						"value" => 4,
						"text" => "Oldest"
					],
					[
						"value" => 5,
						"text" => "Most comments"
					]
				];
				foreach ($options as $option) :
				?>
  				<option value="<?= $option['value'] ?>">
  					<?= $option['text'] ?>
  				</option>
  			<?php endforeach; ?>
  		</select>
  	</div>


  	<div class="sb-widget">
  		<h2 class="sb-title">Categories</h2>
  		<ul class="sb-cata-list">

  			<!-- categories->getAll() -->
  			<?php foreach ($categories as $category) : ?>
  				<li><a class="filter-cat" href="#" data-id="<?= $category->id ?>"><?= strtoupper($category->name) ?><span><strong>posts : <?= $category->numPosts ?></strong></span></a></li>
  			<?php endforeach; ?>

  		</ul>
  	</div>
  	<!-- <div class="sb-widget">
  		<h2 class="sb-title">Latest News</h2>
  		<div class="latest-news-widget">
  			<div class="ln-item">
  				<img src="app/assets/img/blog-thumbs/1.jpg" alt="">
  				<div class="ln-text">
  					<div class="ln-date">April 1, 2019</div>
  					<h6>10 Amazing new games</h6>
  					<div class="ln-metas">
  						<div class="ln-meta">By Admin</div>
  						<div class="ln-meta">in <a href="#">Games</a></div>
  						<div class="ln-meta">3 Comments</div>
  					</div>
  				</div>
  			</div>
  			<div class="ln-item">
  				<img src="app/assets/img/blog-thumbs/2.jpg" alt="">
  				<div class="ln-text">
  					<div class="ln-date">April 1, 2019</div>
  					<h6>10 Amazing new games</h6>
  					<div class="ln-metas">
  						<div class="ln-meta">By Admin</div>
  						<div class="ln-meta">in <a href="#">Games</a></div>
  						<div class="ln-meta">3 Comments</div>
  					</div>
  				</div>
  			</div>
  			<div class="ln-item">
  				<img src="app/assets/img/blog-thumbs/3.jpg" alt="">
  				<div class="ln-text">
  					<div class="ln-date">April 1, 2019</div>
  					<h6>10 Amazing new games</h6>
  					<div class="ln-metas">
  						<div class="ln-meta">By Admin</div>
  						<div class="ln-meta">in <a href="#">Games</a></div>
  						<div class="ln-meta">3 Comments</div>
  					</div>
  				</div>
  			</div>
  			<div class="ln-item">
  				<img src="app/assets/img/blog-thumbs/4.jpg" alt="">
  				<div class="ln-text">
  					<div class="ln-date">April 1, 2019</div>
  					<h6>10 Amazing new games</h6>
  					<div class="ln-metas">
  						<div class="ln-meta">By Admin</div>
  						<div class="ln-meta">in <a href="#">Games</a></div>
  						<div class="ln-meta">3 Comments</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div> -->