<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class PageController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function home()
    {

        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();

        $this->view("home", [
            "title" => "HOME PAGE",
            "categories" => $categories,
        ]);
    }

    public function author()
    {
        $this->view("author");
    }


    public function createComment()
    {

        $loggedUser = $_POST['loggedUserId'];
        $postId = $_POST['postId'];
        $content = $_POST['content'];

        $model = new Comment($this->db);

        $errors = [];


        $result = $model->addComment($content, $loggedUser, $postId);

        if ($result) {
            // $this->post($postId);
            // $this->post($postId);
            $commentModel = new Comment($this->db);

            $comments = $commentModel->getAllForPost($postId);

            foreach ($comments as $comment) {

                $comment->created_at = date("F j, Y. H:i", strtotime($comment->created_at));
                $comment->modified_at = date("F j, Y. H:i", strtotime($comment->modified_at));
            }
            $data = [
                "comments" => $comments
            ];

            $this->json($data);
        }
    }

    public function editComment()
    {

        $id = $_POST['id'];
        $content = $_POST['content'];

        $model = new Comment($this->db);

        $errors = [];

        $comment = $model->getOne($id);

        if ($comment) {


            if ($comment->content !== $content) {

                $model->editComment($id, $content);
            }
        }
    }

    public function post($id)
    {
        $postModel = new Post($this->db);
        $post = $postModel->getOne($id);
        $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        $post->modified_at = date("F j, Y. H:i", strtotime($post->modified_at));
        if ($post) {

            $commentModel = new Comment($this->db);
            $categoryModel = new Category($this->db);
            $userModel = new User($this->db);

            $categories = $categoryModel->getAll();
            $users = $userModel->getAll();
            $comments = $commentModel->getAllForPost($post->id);

            foreach ($comments as $comment) {

                $comment->created_at = date("F j, Y. H:i", strtotime($comment->created_at));
                $comment->modified_at = date("F j, Y. H:i", strtotime($comment->modified_at));
            }


            if (isset($_SESSION['errors'])) {
                unset($_SESSION['errors']);
            }

            $this->viewWithFolder("posts", "show", [
                "post" => $post,
                "comments" => $comments,
                "categories" => $categories,
                "users" => $users
            ]);
        } else {
            $this->redirect("index.php");
        }
    }

    public function getAjax($id)
    {
        $commentModel = new Comment($this->db);

        $comments = $commentModel->getAllForPost($id);

        foreach ($comments as $comment) {

            $comment->created_at = date("F j, Y. H:i", strtotime($comment->created_at));
            $comment->modified_at = date("F j, Y. H:i", strtotime($comment->modified_at));
        }

        $data = [
            "comments" => $comments,
            "title" => $comments[0]->title
        ];

        $this->json($data);
    }

    public function getAjaxSingleComment($id)
    {
        $commentModel = new Comment($this->db);
        $comment = $commentModel->getOne($id);
        $comment->modified_at = date("F j, Y. H:i", strtotime($comment->modified_at));


        $data = [
            "comment" => $comment
        ];

        $this->json($data);
    }

    public function removeComment($id)
    {
        $commentModel = new Comment($this->db);
        $comment = $commentModel->getOne($id);
        $errors = [];
        if ($comment) {
            $commentModel->removeComment($comment->id);
        } else {
            // puni greske
            $errors = ['There is no comment.'];
        }
    }

    public function posts($limit, $sort)
    {

        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();
        $postModel = new Post($this->db);
        $posts = $postModel->getAllWithPagination($limit, $sort);
        $totalCount = $this->db->paginate("posts");


        foreach ($posts as $post) {

            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }

        $this->viewWithFolder("posts", "index", [
            "categories" => $categories,
            "posts" => $posts,
            "totalCount" => $totalCount

        ]);
    }

    public function postsJSONLimit($limit)
    {

        $postModel = new Post($this->db);
        $posts = $postModel->getAllWithPagination($limit, 3);
        $totalCount = $this->db->paginate("posts");
        foreach ($posts as $post) {

            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }
        $data = [
            "posts" => $posts,
            "totalCount" => $totalCount
        ];

        $this->json($data);
        // echo json_encode($data);
    }

    public function postsJSONByCategory($id_category)
    {

        $postModel = new Post($this->db);
        $posts = $postModel->getAllByCategory($id_category);
        $totalCount = $postModel->paginateByCategory("posts", $id_category);
        foreach ($posts as $post) {
            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }
        $data = [
            "posts" => $posts,
            "totalCount" => $totalCount
        ];

        $this->json($data, 200);
    }

    public function postsJSONFilter($filter)
    {
        header("Content-Type: application/json");

        $postModel = new Post($this->db);
        $filteredPosts = $postModel->getAllWithFilter($filter);
        $totalCount = $this->db->paginate("posts");

        foreach ($filteredPosts as $post) {

            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }

        $data = [
            "posts" => $filteredPosts,
            "totalCount" => $totalCount
        ];

        $this->json($data);
    }


    public function postsJSONSort($sort)
    {
        header("Content-Type: application/json");

        $postModel = new Post($this->db);
        $sortedPosts = $postModel->getAllWithSort($sort);
        $totalCount = $this->db->paginate("posts");

        foreach ($sortedPosts as $post) {

            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }

        $data = [
            "posts" => $sortedPosts,
            "totalCount" => $totalCount
        ];

        $this->json($data);
    }

    public function patchPostContent()
    {

        $id = $_POST['id'];
        $content = $_POST['content'];

        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {


            if ($post->content !== $content) {

                $model->patchPostContent($id, $content);
            }
        }
    }

    public function patchPostTitle()
    {

        $id = $_POST['id'];
        $title = $_POST['title'];

        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {


            if ($post->title !== $title) {

                $model->patchPostTitle($id, $title);
            }
        }
    }


    public function patchPostImage()
    {

        $id = $_GET['id'];

        $file_name = $_FILES['post-img']['name'];
        $file_tmp = $_FILES['post-img']['tmp_name'];
        $file_type = $_FILES['post-img']['type'];
        $file_size = $_FILES['post-img']['size'];

        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {

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
                $newWidth = 200;
                $newHeight = ($newWidth / $width) * $height;
                $newImg = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($newImg, $existingPic, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagefilter($newImg, IMG_FILTER_GRAYSCALE);
                $name = time() . $file_name;
                $newImgPath = 'assets/img/blog/new_' . $name;
                switch ($file_type) {
                    case 'image/jpeg':
                        imagejpeg($newImg, './' . $newImgPath, 75);
                        break;
                    case 'image/png':
                        imagepng($newImg, './' . $newImgPath);
                        break;
                }

                $originalPath = 'assets/img/blog/' . $name;

                if (move_uploaded_file($file_tmp, './' . $originalPath)) {

                    $isInserted = $this->db->insertImage($originalPath, $newImgPath, "posts", $post->id, "league-of-legends");
                    if ($isInserted) {
                    }
                } else {
                    var_dump($errors);
                }
            } else {
            }

            // $model->patchPostTitle($id, $title);
        } else {
            array_push($errors, 'There is no such post.');
        }
    }




    public function patchPostUser()
    {

        $id = $_POST['id'];
        $user = $_POST['user'];

        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {


            if ($post->created_by !== $user) {

                $model->patchPostUser($id, $user);
            }
        } else {
            array_push($errors, 'There is no such post.');
        }
    }


    public function patchPostCategory()
    {

        $id = $_POST['id'];
        $category = $_POST['category'];

        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {


            if ($post->id_category !== $category) {

                $model->patchPostCategory($id, $category);
            }
        } else {
            array_push($errors, 'There is no such post.');
        }
    }


    public function removePost()
    {

        $id = $_POST['id'];


        $model = new Post($this->db);

        $errors = [];

        $post = $model->getOne($id);

        if ($post) {

            $model->removePost($id);
        } else {
            array_push($errors, 'There is no such post.');
        }
    }



    public function games()
    {

        $gameModel = new Game($this->db);
        $games = $gameModel->getAll();

        $this->viewWithFolder("games", "index", [
            "games" => $games,
        ]);
    }

    public function game($id)
    {

        $gameModel = new Game($this->db);
        $game = $gameModel->getOne($id);


        $this->viewWithFolder("games", "show", [
            "game" => $game,
        ]);
    }

    public function categories()
    {
        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();
        echo \json_encode($categories);
    }
}
