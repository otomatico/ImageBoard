<?php

class ThreadHandler
{
    private BoardRepository $board;
    private ThreadRepository $thread;
    private PostRepository $post;
    public function __construct()
    {
        $this->board =  new BoardRepository();
        $this->thread =  new ThreadRepository();
        $this->post =  new PostRepository();
    }

    public function GetTreeByBord($id)
    {
        $threads =  $this->thread->GetByBoard($id);
        foreach ($threads as $item) {
            $item->posts = $this->post->GetByThead($item->id);
        }
        return $threads;
    }
    public function GetPaginedByBoard($boardName,$currentPage,$pageSize)
    {
        $boardItem =  $this->board->GetByName($boardName)[0];
        $Total =  $this->thread->GetTotalByBoard($boardItem->id);
        $threads =  $this->thread->GetPaginedByBoard($boardItem->id,$currentPage,$pageSize);

        foreach ($threads as $item) {
            $item->total_posts = $this->post->GetTotalByThread($item->id);
            $item->posts = $this->post->GetPaginedByThread($item->id, 1, 3);
        }

        $pagined = new Pagined(new PageInfo($currentPage,$pageSize,$Total),$threads);
        return $pagined ;
    }
    public function CreateThread($data){
        
        $name = trim($data['name'] ?? 'Anónimo');
        $subject = trim($data['subject'] ?? '');
        $message = trim($data['message'] ?? '');
        if (empty($message)) {
            die("El mensaje es requerido");
        }
        
        // Procesar imagen
        $imagePath = '';
        $thumbPath = '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];
            
            // Validar tipo y tamaño
            if (!in_array($file['type'], $GLOBALS["AppSettings"]['Thumbnail']["ALLOWED_TYPES"])) {
                die("Tipo de archivo no permitido");
            }
            
            if ($file['size'] > $GLOBALS["AppSettings"]['Thumbnail']["MAX_FILE_SIZE"]) {
                die("El archivo es demasiado grande");
            }
            
            // Generar nombres únicos
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $imagePath = 'uploads/' . $filename;
            $thumbPath = 'uploads/thumbs/' . $filename;
            
            // Mover archivo y crear thumbnail
            if (move_uploaded_file($file['tmp_name'], $imagePath)) {
                createThumbnail($imagePath, $thumbPath, $GLOBALS["AppSettings"]['Thumbnail']["WIDTH"], $GLOBALS["AppSettings"]['Thumbnail']["HEIGHT"]);
            }
        }
    }
}
