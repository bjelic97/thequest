<!-- Header section -->
<header class="header-section">

	<a href="index.php?page=posts" class="site-logo">
		<img src="app/assets/img/logo.png" alt="logo">
	</a>
	<ul class="main-menu">

		<li><a href="index.php">Home</a></li>
		<li><a href="index.php?page=games">Games</a></li>




		<?php if (!isset($_SESSION["user"])) : ?>
			<li><a href="#" id="reg-modal" data-toggle="modal" data-target="#registerModal">Register <i class="fa fa-unlock-alt" aria-hidden="true"></i></a></li>
			<li><a href="#" id="login-modal" data-toggle="modal" data-target="#loginModal">Login <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
		<?php endif; ?>
		<?php if (isset($_SESSION["user"])) : ?>
			<input type="hidden" id="loggedUserId" value=<?= $_SESSION["user"]->id ?> />
			<input type="hidden" id="loggedUserRole" value=<?= $_SESSION["user"]->id_user_role ?> />
			<input type="hidden" id="loggedUserUsername" value=<?= $_SESSION["user"]->username ?> />
			<li class="nav-item">
				<a class="nav-link" href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['user']->username ?></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="index.php?page=logout">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
			</li>
		<?php endif; ?>
	</ul>

	<?php

	if (!isset($_SESSION["user"])) {
		require_once "pages/auth/login.php";
		require_once "pages/auth/register.php";
	}

	?>



</header>

<!-- Header section end -->