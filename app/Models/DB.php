<?php



namespace App\Models;

class DB
{
    private $server;
    private $database;
    private $username;
    private $password;

    public $conn;

    private $offset = 4;

    public function __construct($server, $database, $username, $password)
    {
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }


    public function getOffset()
    {
        return $this->offset;
    }

    private function connect()
    {
        try {
            $this->conn = new \PDO("mysql:host={$this->server};dbname={$this->database};charset=utf8", $this->username, $this->password);

            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function executeQuery(string $query)
    {

        return $this->conn->query($query)->fetchAll();
    }

    public function executeOneRow(string $query, array $params)
    {
        $prepare = $this->conn->prepare($query);
        $prepare->execute($params);
        return $prepare->fetch();
    }

    public function executeQueryWithParamsBindParam($query, array $params)
    {
        $prepare = $this->conn->prepare($query);

        $prepare->bindParam(':limit', $params["limit"], \PDO::PARAM_INT);
        $prepare->bindParam(':offset', $params["offset"], \PDO::PARAM_INT);

        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function executeQueryWithParamsBindParamSingle($query, array $params)
    {
        $prepare = $this->conn->prepare($query);

        $prepare->bindParam(':filter', $params["filter"]);


        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function executeQueryWithParamsBindParamSort($query, array $params)
    {
        $prepare = $this->conn->prepare($query);

        $prepare->bindParam(':sort', $params["sort"]);


        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function executeQueryWithParams($query, $params)
    {
        $prepare = $this->conn->prepare($query);
        $prepare->execute($params);
        return $prepare->fetchAll();
    }

    public function executeGet($query)
    {
        return $this->conn->query($query)->fetchAll();
    }

    //insert into users (?, ?, ?, ?)
    // ["ime", "prezime"....]
    public function executeNonGet($query, array $params)
    {

        $prepared = $this->conn->prepare($query);
        $prepared->execute($params);
    }

    public function insertImage($originalPath, $newPath, $entityType, $id_entity, $alt)
    {

        $insert = $this->conn->prepare("INSERT INTO images VALUES(NULL, ?, ?, ?, ?, ?)");
        $isInserted = $insert->execute([$entityType, $id_entity, $originalPath, $alt, $newPath]);
        return $isInserted;
    }

    public function updateImage($originalPath, $newPath, $entityType, $id_entity, $alt)
    {

        $insert = $this->conn->prepare("UPDATE images SET src = ?, alt = ?, src_small = ? WHERE id_entity = ? AND entity_type = ?");
        $isInserted = $insert->execute([$originalPath, $alt, $newPath, $id_entity, $entityType]);
        return $isInserted;
    }


    // fix
    function paginate($table)
    {

        $result = $this->conn->query("SELECT COUNT(*) AS total_count FROM " . $table . " WHERE isDeleted = 0")->fetch();
        return ceil($result->total_count / $this->offset);
    }
}
