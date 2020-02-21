<?php

namespace App\Models;

class Comment
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAllForPost($idPost)
    {
        $query = "SELECT c.id, c.content, c. created_at, c.modified_at, c.created_by, u.username, p.title FROM comments c INNER JOIN users u ON c.created_by = u.id INNER JOIN posts p ON c.id_post = p.id WHERE p.id = ? ORDER BY c.created_at DESC";
        return $this->db->executeQueryWithParams($query, [$idPost]);
    }

    public function addComment($content, $createdById, $idPost)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [
            'content' => $content,
            'created_at' => $current_date,
            'modified_at' => $current_date,
            'created_by' =>  $createdById,
            'modified_by' => $createdById,
            'id_post' =>  $idPost
        ];



        $query = "INSERT INTO comments (id,content, created_at, modified_at, created_by, modified_by, id_post)
            VALUES (null,:content,:created_at,:modified_at,:created_by, :modified_by, :id_post)";

        $this->db->executeNonGet($query, $params);
    }



    public function getOne($id)
    {
        $query = "SELECT c.id, c.content, c.modified_at FROM comments c WHERE c.id = ? ORDER BY c.created_at DESC ";
        return $this->db->executeOneRow($query, [$id]);
    }


    public function editComment($id, $content)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [

            'content' => $content,
            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE comments SET content = :content, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }

    public function removeComment($id)
    {

        $params = [
            'id' => $id
        ];

        $query = "DELETE FROM comments WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }
}
