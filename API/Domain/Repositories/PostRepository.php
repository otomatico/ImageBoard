<?php
class PostRepository
{
    private $_cells = "thread_id, subject, name, email, message, image_path, thumb_path";
    public PDO $db;
    private $queries = array(
        "GetById" => "SELECT id, :cells FROM posts WHERE id = :id;",
        "GetByThread" => "SELECT id, :cells FROM posts WHERE thread_id = :thread_id;",
        "GetTotalByThread" => "SELECT Count(id) as Total FROM `posts` where thread_id = :thread_id;",
        "GetPaginedByThread" => "SELECT id, :cells FROM `posts` where thread_id = :thread_id; ORDER BY id LIMIT  :pageSize OFFSET (:curretPage - 1)* :pageSize )",
        "Create" => "INSERT INTO `posts` (:cells, create_at) VALUES (':thead_id', ':name', ':email', ':message', ':image_path', ':thumb_path', CURRENT_TIMESTAMP());"

    );
    public function __construct()
    {
        $this->db = $GLOBALS["Database"];
    }

    public function GetByThead($threadId)
    {
        try {
            $param = [':cells' => $this->_cells, ':thread_id' => $threadId];
            $query = str_template($this->queries['GetByThread'], $param);
            $stm = $this->db->query($query);
            return $stm->fetchAll(PDO::FETCH_CLASS, "post");
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
    public function GetTotalByThread($id): int
    {
        try {
            $param = [':cells' => $this->_cells, ':thread_id' => $id];
            $query = str_template($this->queries['GetTotalByThread'], $param);
            $stm = $this->db->query($query);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result["Total"];
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
    public function GetPaginedByThread($threadId, $currentPage, $pageSize)
    {
        try {
            $param = [':cells' => $this->_cells, ':thread_id' => $threadId, ':currentPage' => $currentPage, ':pageSize' => $pageSize];
            $query = str_template($this->queries['GetPaginedByThread'], $param);
            $stm = $this->db->query($query);
            return $stm->fetchAll(PDO::FETCH_CLASS, "post");
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }

    public function Create(int $thead_id, string $name, string $email, string $message, string $image_path, string $thumb_path)
    {
        try {
            $param = array(
                ':cells' => $this->_cells,
                ':thead_id' => $thead_id,
                ':name' => $name,
                ':email' => $email,
                ':message' => $message,
                ':image_path' => $image_path,
                ':thumb_path' => $thumb_path
            );
            $query = str_template($this->queries['Create'], $param);
            $this->db->query($query);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
}
