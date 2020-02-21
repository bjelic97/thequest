<?php

namespace App\Models;


class User
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->executeGet("SELECT id,firstname,lastname,username,email,password from users");
    }

    public function addUser($firstName, $lastName, $email, $username, $password)
    {
        $current_date = date('Y-m-d H:i:s');


        $params = [
            'firstname' => $firstName,
            'lastname' => $lastName,
            'email' => $email,
            'username' => $username,
            'password' => md5($password),
            'created_at' => $current_date,
            'modified_at' => $current_date,
            'id_user_role' => 2
        ];



        $query = "INSERT INTO users (id,firstname, lastname, email, username, password, created_at, modified_at, id_user_role)
            VALUES (null,:firstname,:lastname,:email,:username, :password, :created_at, :modified_at, :id_user_role)";

        $this->db->executeNonGet($query, $params);
    }

    public function find($id)
    {
        $data = $this->db->executeGet("select * from users where id = " . $id);

        if (!count($data)) {
            return null;
        }

        return $data[0];
    }

    public function findByUsernameAndPassword($username, $password)
    {
        $data = $this->db->executeGet("select * from users where 
        password = '" . md5($password) . "'" . " AND username = '" . $username . "'");

        if (!count($data)) {
            return null;
        }

        return $data[0];
    }
}
