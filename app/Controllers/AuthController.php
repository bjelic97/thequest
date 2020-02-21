<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class AuthController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login()
    {
        $model = new User($this->db);

        $errors = [];

        $regPassword = "/^[\w\d]{5,15}$/";

        if (!isset($_POST["password"])) {
            array_push($errors, "Password is required.");
        }

        if (!preg_match($regPassword, $_POST["password"])) {
            array_push($errors, "Password in bad format.");
        }

        if (!isset($_POST["username"])) {
            array_push($errors, "Username is required.");
        }

        if (!preg_match($regPassword, $_POST["username"])) {
            array_push($errors, "Username in bad format.");
        }

        if (count($errors)) {
            $_SESSION['errors'] = $errors;
            $this->json($errors, 400);
        } else {

            $user = $model->findByUsernameAndPassword($_POST["username"], $_POST["password"]);
            if (!$user) {
                array_push($errors, "Invalid username and password combination.");
                $this->json($errors, 404);
            } else {
                $_SESSION["user"] = $user;

                $this->json($user, 200);
                // nesto nece pa sam u JS-u pozvao window.location $this->redirect("index.php");
            }
        }
    }

    public function register()
    {
        if (isset($_POST['regUser'])) {

            $errors = [];


            $regFirstname = "/^[A-ZŽŠĐĆČ][a-zžšđčć]{3,12}$/";
            $regPassword = "/^[\w\d]{5,15}$/";

            if (!isset($_POST["firstname"])) {
                array_push($errors, "Firstname is required.");
            }

            if (!preg_match($regFirstname, $_POST["firstname"])) {

                array_push($errors, "Firstname not in right format.");
            }


            if (!isset($_POST["lastname"])) {
                array_push($errors, "Lastname is required.");
            }

            if (!preg_match($regFirstname, $_POST["lastname"])) {

                array_push($errors, "Lastname not in right format.");
            }



            if (!isset($_POST["email"])) {
                array_push($errors, "Email is required.");
            }

            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email must be valid.");
            }



            if (!isset($_POST["username"])) {
                array_push($errors, "Username is required.");
            }

            if (!preg_match($regPassword, $_POST["username"])) {

                array_push($errors, "Username not in right format.");
            }


            if (!isset($_POST["password"])) {
                array_push($errors, "Password is required.");
            }

            if (!preg_match($regPassword, $_POST["password"])) {

                array_push($errors, "Password not in right format.");
            }



            if (count($errors) > 0) {
                $this->json($errors, 400);
            } else {

                $model = new User($this->db);

                try {

                    $users = $model->getAll();

                    foreach ($users as $user) {

                        if ($user->email === $_POST['email']) {
                            array_push($errors, "Email is already in use.");
                        }
                        if ($user->username === $_POST['username']) {
                            array_push($errors, "Username is already in use.");
                        }
                        if ($user->password === $_POST['password']) {
                            array_push($errors, "Password is already in use.");
                        }
                    }

                    if (count($errors) > 0) {
                        $this->json($errors, 400);
                    } else {
                        $result = $model->addUser($_POST["firstname"], $_POST["lastname"], $_POST["email"],  $_POST["username"], $_POST["password"]);
                        if ($result === null) {
                            $createdId = $this->db->conn->lastInsertId();
                            if ($createdId) {
                                $newUser = $model->find($createdId);
                                if ($newUser !== null) {
                                    $this->json($newUser, 201);
                                } else {
                                    array_push($errors, 'No such user.');
                                    $this->json($errors, 404);
                                }
                            } else {
                                array_push($errors, 'An error ocurred.');
                                $this->json($errors, 500);
                            }
                        }
                    }
                } catch (\PDOException $e) {
                    $data = $e->getMessage();
                    array_push($errors, $data);
                    $this->json($errors, 500);
                }
            }
        } else {
            array_push($errors, "Not post request.");
            $this->json($errors, 403);
            // ne radi $this->redirect('index.php');
        }
    }




    public function logout()
    {
        $_SESSION["user"] = null;
        $this->redirect("index.php");
    }
}
