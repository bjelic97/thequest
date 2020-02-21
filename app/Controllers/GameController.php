<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Game;


class GameController extends Controller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {

        $gameModel = new Game($this->db);
        $games = $gameModel->getAll();

        $this->viewWithFolder("games", "index", [
            "games" => $games
        ]);
    }

    public function show($id)
    {

        $gameModel = new Game($this->db);
        $game = $gameModel->getOne($id);

        $this->view("game", "show", [
            "game" => $game
        ]);
    }
}
