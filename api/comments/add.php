<?php
    include "../../config/base_url.php";
    include "../../config/db.php";

    $data = json_decode(file_get_contents("php://input"), true);

    if(isset($data["text"], $data["blog_id"], $data["author_id"])
    && strlen($data["text"]) > 0
    && intval($data["blog_id"])
    && intval($data["author_id"])
    ){
        $text = $data["text"];
        $blog_id = $data["blog_id"];
        $author_id = $data["author_id"];

        $prep = mysqli_prepare($con, 
        "INSERT INTO comments (text, author_id, blog_id)
        VALUES(?, ?, ?)");
        mysqli_stmt_bind_param($prep, "sii", $text, $author_id, $blog_id);
        mysqli_stmt_execute($prep);

        $commentId = mysqli_stmt_insert_id($prep);

        $query = mysqli_query($con, 
        "SELECT c.*, u.full_name FROM comments c 
        LEFT OUTER JOIN users u ON c.author_id = u.id
        WHERE c.id=$commentId");

        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            echo json_encode($row);
        }
    }else{
        echo "error";
    }
?>