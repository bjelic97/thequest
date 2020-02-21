<?php

use \App\Models\DB;
use \App\Models\Post;

if (isset($_POST['createPost'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = (int) $_POST['categories'];

    $file_name = $_FILES['post-img']['name'];
    $file_tmp = $_FILES['post-img']['tmp_name'];
    $file_type = $_FILES['post-img']['type'];
    $file_size = $_FILES['post-img']['size'];
    $errors = [];



    if (!isset($_POST["title"]) || strlen($title) == 0) {
        array_push($errors, "Title field is required.");
    }

    if (!isset($_POST["content"]) || strlen($content) == 0) {
        array_push($errors, "Content field is required.");
    }

    if (!isset($_POST["categories"]) || $category == 0) {
        array_push($errors, "Category field is required.");
    }


    $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
    if (!in_array($file_type, $allowed_types)) {
        array_push($errors, "Wrong file type.");
    }
    if ($file_size > 3000000) {
        array_push($errors, "Max size - 3MB.");
    }


    if (count($errors) == 0) {


        try {
            $db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

            $postModel = new Post($db);
            $userId = (int) $_SESSION['user']->id;

            $postModel->createPost($userId, $title, $content, $category);
            $createdPostId = (int) $db->conn->lastInsertId();
            var_dump($createdPostId);


            if ($createdPostId) {



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

                    $isInserted = $db->insertImage($originalPath, $newImgPath, 'posts', $createdPostId, $file_name);

                    if ($isInserted) {
                        header('Location: index.php?page=posts&id=' . $createdPostId);
                    } else {
                        array_push($errors, 'An error ocurred while inserting image');
                    }
                }
            }
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            http_response_code(500);
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
} else {

    http_response_code(400);
}


?>


<section class="blog-section spad">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 blog-posts">

                <div class="blog-post featured-post">

                    <form id="upload-form" method="POST" enctype="multipart/form-data" action="index.php?page=posts&id=new">


                        <div class="form-group">
                            <input id="field-title" name="title" class="form-control form-control-lg " type="text" placeholder="Title">

                        </div>

                        <div class="post-metas">
                            <div class="form-group">

                                <select id="ddl-categories" name="categories" class="form-control">
                                    <option>Choose category</option>
                                    <?php foreach ($categories as $category) : ?>

                                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">

                            <textarea class="form-control textareaPost " name="content" id="content" placeholder="Add content"></textarea>
                        </div>


                        <label class="file">

                            <input type="file" name="post-img" id="post-img" class="form-control-file">

                        </label>

                        <input type="submit" name="createPost" id="createPost" value="&#xf067 Create" id="edit" class="btn btn-success btn-lg btn-block content-post fa fa-input bot" />

                        <?php if (isset($_SESSION['errors'])) : ?>
                            <div class="row">
                                <div class="col">
                                    <div id="errors" class="alert alert-danger text-center" role="alert">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <?php foreach ($_SESSION['errors'] as $error) : ?>

                                            <div class="text-center"><?= $error ?></div>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>