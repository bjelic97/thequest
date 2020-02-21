<?php
session_start();


require_once "app/config/autoload.php";
require_once "app/config/database.php";

use App\Controllers\PageController;
use App\Controllers\AuthController;
use App\Models\DB;

$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

$pageController = new PageController($db);
$authController = new AuthController($db);


if (isset($_GET['page'])) {


    if (isset($_GET['id'])) {
        switch ($_GET['page']) {
            case "games":
                $pageController->game($_GET['id']);
                break;

            case "posts":
                if ($_GET['id'] == "new") {
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['user']->id_user_role == 1) {
                            $pageController->post($_GET['id']);
                            break;
                        }
                    } else {
                        $pageController->posts($limit = 0, $sort = 3);
                        break;
                    }
                }
                $pageController->post($_GET['id']);
                break;

            default:
                $pageController->posts($limit = 0, $sort = 3);
                break;
        }
    } else {
        switch ($_GET['page']) {
            case "login":
                $authController->login();
                break;

            case "register":
                $authController->register();
                break;

            case "logout":
                $authController->logout();
                exit;
                break;
            case "author":
                $pageController->author();
                break;
            case "posts":
                if (isset($_GET['limit'])) {
                    $pageController->postsJSONLimit($_GET['limit']);
                    break;
                } else if (isset($_GET['filter'])) {
                    $pageController->postsJSONFilter($_GET['filter']);
                    break;
                } else if (isset($_POST['id_category'])) {
                    $pageController->postsJSONByCategory($_POST['id_category']);
                    break;
                } else if (isset($_GET['sort'])) {
                    $pageController->postsJSONSort($_GET['sort']);
                    break;
                } else if (isset($_GET['edit'])) {
                    switch ($_GET['edit']) {
                        case "content":
                            if (isset($_POST['id']) && isset($_POST['content']))
                                $pageController->patchPostContent();
                            break;
                        case "title":
                            if (isset($_POST['id']) && isset($_POST['title']))
                                $pageController->patchPostTitle();
                            break;
                        case "user":
                            if (isset($_POST['id']) && isset($_POST['user']))
                                $pageController->patchPostUser();
                            break;
                        case "category":
                            if (isset($_POST['id']) && isset($_POST['category']))
                                $pageController->patchPostCategory();
                            break;
                            // case "img":
                            //     if (isset($_GET['id']))
                            //         // $pageController->patchPostImage();
                            //         break; something went wrong
                    }
                } else if (isset($_GET['remove'])) {
                    if (isset($_POST['id']))
                        $pageController->removePost();
                    break;
                } else {
                    $pageController->posts($limit = 0, $sort = 3);
                }
                break;

            case "comments":
                if (isset($_GET['create'])) {
                    if (isset($_POST['content']) && isset($_POST['loggedUserId']) && isset($_POST['postId'])) {
                        $pageController->createComment();
                        break;
                    }
                } else if (isset($_GET['edit'])) {
                    if (isset($_POST['content']) && isset($_POST['id'])) {
                        $pageController->editComment();
                        break;
                    }
                } else if (isset($_GET['idAjax'])) {
                    $pageController->getAjax($_GET['idAjax']);
                    break; // clean this 
                } else if (isset($_GET['idAjaxSingle'])) {
                    $pageController->getAjaxSingleComment($_GET['idAjaxSingle']);
                    break; // clean this 
                } else if (isset($_GET['remove'])) {
                    $pageController->removeComment($_POST['id']);
                    break; // clean this 
                }

            case "games":
                $pageController->games();
                break;
            default:
                $pageController->posts($limit = 0, $sort = 3);
                break;
        }
    }
} else {
    $pageController->posts($limit = 0, $sort = 3);
}
