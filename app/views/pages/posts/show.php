<?php

// nesto nije hteo da pogadja kontroler


if (isset($_SESISON['user'])) {

	if ($_SESSION['user']->id_user_role != 1) {
		header('Location: index.php?page=posts');
	}
}

use \App\Models\DB;



if (isset($_GET['edit'])) {
	if ($_GET['edit'] == 'img') {
		$id = $_GET['id'];

		$file_name = $_FILES['post-img']['name'];
		$file_tmp = $_FILES['post-img']['tmp_name'];
		$file_type = $_FILES['post-img']['type'];
		$file_size = $_FILES['post-img']['size'];



		$errors = [];




		$allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
		if (!in_array($file_type, $allowed_types)) {
			array_push($errors, "Wrong file type.");
		}
		if ($file_size > 3000000) {
			array_push($errors, "Max size - 3MB.");
		}
		if (count($errors) == 0) {

			list($width, $height) = getimagesize($file_tmp);


			$existingPic = null;
			switch ($file_type) {
				case 'image/jpeg':
					$existingPic = imagecreatefromjpeg($file_tmp);
					break;
				case 'image/png':
					$existingPic = imagecreatefrompng($file_tmp);
					break;
			}
			$newWidth = 500;
			$newHeight = 400;
			$newImg = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($newImg, $existingPic, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			$name = time() . $file_name;
			$newImgPath = 'app/assets/img/blog/new_' . $name;
			switch ($file_type) {
				case 'image/jpeg':
					imagejpeg($newImg, $newImgPath, 75);
					break;
				case 'image/png':
					imagepng($newImg, $newImgPath);
					break;
			}

			$originalPath = 'app/assets/img/blog/' . $name;

			if (move_uploaded_file($file_tmp,  $originalPath)) {

				$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
				$isUpdated = $db->updateImage($originalPath, $newImgPath, "posts", $post->id, "league-of-legends");
				if ($isUpdated) {
					header('Location: index.php?page=posts&id=' . $post->id);
				}
			} else {
				var_dump($errors);
			}
		} else {
		}
	}
} else {

	// insert slike 
}


?>


<?php if ($_GET['id'] != 'new') : ?>

	<?php include "partials/update.php" ?>


<?php endif; ?>




<?php if ($_GET['id'] == 'new') : ?>

	<?php if (isset($_SESSION['user'])) : ?>


		<?php if ($_SESSION['user']->id_user_role == 1) : ?>

			<?php include "partials/create.php" ?>


		<?php endif; ?>



	<?php endif; ?>

<?php endif; ?>