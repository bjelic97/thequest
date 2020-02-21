<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="app/assets/img/header-bg/2.jpg">
	<div class="container">
		<h2>
			<?php
			if (isset($_GET['page'])) {

				switch ($_GET['page']) {
					case "posts":
						if (isset($_GET['id'])) {

							if ($_GET['id'] == 'new') {
								echo "Create";
								break;
							} else {
								echo "Post";
								break;
							}
						}

					case "author":
						echo "Author";
						break;
					case "games":
						echo "Games";
						break;
				}
			}

			?>
		</h2>
	</div>
</section>
<!-- Page top section end -->