<?php

namespace App\Models;

class Game
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->executeQuery("SELECT g.id, g.name, g.description, c.name as categoryName, i.src,i.alt FROM games g INNER JOIN categories c ON g.id_category = c.id INNER JOIN images i ON i.id_entity = g.id WHERE i.entity_type = 'games'");
    }

    public function getOne($id)
    {

        $game = $this->db->executeOneRow("SELECT * FROM games WHERE id = ?", [$id]);
    }
}
