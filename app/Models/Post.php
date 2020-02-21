<?php

namespace App\Models;

class Post
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAllWithPagination($limit = 0, $sort = 3)
    {

        switch ($sort) {
            case 1:
                $orderby = "p.title ASC";
                break;
            case 2:
                $orderby = "p.title DESC";
                break;
            case 3:
                $orderby = "p.created_at DESC";
                break;
            case 4:
                $orderby = "p.created_at ASC";
                break;
            case 5:
                $orderby = "commNum DESC";
                break;
        }

        $params = [
            // 'orderby' =>  $orderby,
            'limit' => ((int) $limit) * $this->db->getOffset(),
            'offset' => $this->db->getOffset()
        ];

        $query = "SELECT p.id, p.title, p.created_at, p.content, c.name AS category, u.firstname, u.lastname,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE isDeleted = 0 GROUP BY p.id ORDER BY p.created_at DESC LIMIT :limit ,:offset";
        return $this->db->executeQueryWithParamsBindParam($query, $params);
    }

    public function getOne($id)
    {
        $query = "SELECT p.id, p.title, p.created_at, p.modified_at, p.content, c.name AS category, u.firstname, u.lastname, u.username,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE p.id = ? and isDeleted = 0";
        return $this->db->executeOneRow($query, [$id]);
    }


    public function patchPostContent($id, $content)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [

            'content' => $content,
            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE posts SET content = :content, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }

    public function patchPostTitle($id, $title)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [

            'title' => $title,
            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE posts SET title = :title, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }

    public function patchPostUser($id, $created_by)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [

            'created_by' => $created_by,
            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE posts SET created_by = :created_by, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }


    public function patchPostCategory($id, $id_category)
    {
        $current_date = date('Y-m-d H:i:s');

        $params = [

            'id_category' => $id_category,
            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE posts SET id_category = :id_category, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }


    public function removePost($id)
    {

        $current_date = date('Y-m-d H:i:s');

        $params = [

            'modified_at' => $current_date,
            'id' => $id
        ];

        $query = "UPDATE posts SET isDeleted = 1, modified_at = :modified_at WHERE id = :id";

        $this->db->executeNonGet($query, $params);
    }


    public function createPost($created_by, $title, $content, $id_category)
    {

        $current_date = date('Y-m-d H:i:s');

        $params = [

            'created_by' => $created_by,
            'modified_by' => $created_by,
            'created_at' => $current_date,
            'modified_at' => $current_date,
            'title' => $title,
            'content' => $content,
            'id_category' => $id_category,
            'isDeleted' => 0
        ];

        $query = "INSERT INTO posts (id,created_by, modified_by,created_at, modified_at, title, content, id_category, isDeleted)
            VALUES (null,:created_by,:modified_by,:created_at,:modified_at, :title, :content, :id_category, :isDeleted)";

        $this->db->executeNonGet($query, $params);
    }




    public function getAllWithFilter($filter)
    {

        $filterQ = "%" . strtolower($filter) . "%";

        $params = [
            'filter' => $filterQ
        ];

        $query = "SELECT p.id, p.title, p.created_at, p.content, c.name AS category, u.firstname, u.lastname,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE isDeleted = 0 GROUP BY p.id HAVING LOWER(p.title) LIKE :filter";

        return $this->db->executeQueryWithParamsBindParamSingle($query, $params);
    }

    public function getAllWithSort($sort)
    {

        $query = "SELECT p.id, p.title, p.created_at, p.content, c.name AS category, u.firstname, u.lastname,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE isDeleted = 0  GROUP BY p.id";

        switch ($sort) {
            case 1:
                $query .= " ORDER BY p.title ASC";
                break;
            case 2:
                $query .= " ORDER BY p.title DESC";
                break;
            case 3:
                $query .= " ORDER BY p.created_at DESC";
                break;
            case 4:
                $query .= " ORDER BY p.created_at ASC";
                break;
            case 5:
                $query .= " ORDER BY commNum DESC";
                break;
        }

        $params = [
            'sort' => $sort
        ];

        return $this->db->executeQueryWithParamsBindParamSort($query, $params);
    }

    public function getAllByCategory($id_category)
    {
        $query = "SELECT p.id, p.title, p.created_at, p.content, c.name AS category, u.firstname, u.lastname,  COUNT(com.id) as commNum, i.src,i.alt ,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE p.isDeleted = 0 AND c.id = ? GROUP BY p.id";

        return $this->db->executeQueryWithParams($query, [$id_category]);
    }

    function paginateByCategory($table, $id_category)
    {
        $query = "SELECT COUNT(*) AS total_count FROM " . $table . " WHERE isDeleted = 0 AND id_category = ?";
        $result = $this->db->executeOneRow($query, [$id_category]);
        return ceil($result->total_count / $this->db->getOffset());
    }
}
