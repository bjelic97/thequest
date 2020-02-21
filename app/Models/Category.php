<?php

namespace App\Models;

class Category
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->executeQuery("SELECT c.id, c.name, COUNT(p.id) AS numPosts FROM categories c LEFT JOIN posts p ON c.id = p.id_category GROUP BY c.id ORDER BY numPosts DESC");
    }
}
