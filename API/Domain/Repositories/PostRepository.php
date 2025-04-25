<?php
class PostRepository
{
    public PDO $db;
    private $queries = array(
        "GetByThread" => "SELECT id, thread_id, subject, name, email, message, image_path, thumb_path FROM posts WHERE thread_id = :thread_id;",
        "GetById" => "SELECT id, thread_id, subject, name, email, message, image_path, thumb_path FROM posts WHERE id = :id;",
        "Create" => "INSERT INTO `posts` VALUES (':thead_id', ':name', ':email', ':message', ':image_path', ':thumb_path', CURRENT_TIMESTAMP());"

    );
    public function __construct()
    {
        $this->db = $GLOBALS["Database"];
    }

    public function GetByThead($id)
    {
        try {
            $param = [':thread_id' => $id];
            $query = str_template($this->queries['GetByThread'], $param);
            $stm = $this->db->query($query);
            return $stm->fetchAll(PDO::FETCH_CLASS, "post");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function Create(int $thead_id, string $name, string $email, string $message, string $image_path, string $thumb_path)
    {
        try {
            $param = array(
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
