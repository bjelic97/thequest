<?php

namespace App\Controllers;

class Controller
{

    protected function viewWithFolder($subFolder, $fileName, $data = [])
    {

        extract($data);

        include "app/views/head.php";
        include "app/views/nav.php";
        if ($subFolder === 'posts' && $fileName === 'index') {

            include "app/views/slider.php";
        } else {

            include "app/views/static_slider.php";
        }

        include "app/views/pages/$subFolder/$fileName.php";
        include "app/views/footer.php";
    }

    protected function view($fileName, $data = [])
    {

        extract($data);

        include "app/views/head.php";
        include "app/views/nav.php";
        if ($fileName !== 'posts') {
            include "app/views/static_slider.php";
        } else {
            include "app/views/slider.php";
        }

        include "app/views/pages/$fileName.php";
        include "app/views/footer.php";
    }

    public function redirect($page)
    {
        header("Location: " . $page);
    }

    protected function json($data = null, $statusCode = 200)
    {
        header("content-type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }

    protected function errors($array)
    {
        return var_dump($array);
    }
}
