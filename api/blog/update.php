<?php
    include "../../config/base_url.php";
    include "../../config/db.php";

    if(isset($_GET["id"], $_POST["title"], 
    $_POST["description"], $_POST["category_id"]) &&
    strlen($_POST["title"]) > 0 &&
    strlen($_POST["description"]) > 0 &&
    intval($_POST["category_id"]) &&
    intval($_GET["id"])
    ){
        $title = $_POST["title"];
        $desc = $_POST["description"];
        $cat_id = $_POST["category_id"];
        $id = $_GET["id"];
        session_start();
        // $author = $_SESSION["id"];

        if(isset($_FILES["image"], $_FILES["image"]["name"]) &&
        strlen($_FILES["image"]["name"])> 0
        ){
            $path = mysqli_query($con, 
            "SELECT img FROM blogs WHERE id=".$id);
            
            // /image/blogs/1234565432.png

            // __DIR__ $BASE_URL/imae

            $a = mysqli_fetch_assoc($path);

            $old_path = __DIR__."../../".$a;
            if(file_exists($old_path)){
                unlink($old_path);
            }

            $ext = end(explode(".", $_FILES["image"]["name"]));
            // image.png //["image", "png"]
            $image_name = time().".".$ext;
            move_uploaded_file($_FILES["image"]["tmp_name"], 
            "../../images/blogs/$image_name");
            $new_path = "/images/blogs/".$image_name;


            $prep = mysqli_prepare($con, 
            "UPDATE blogs SET title=?, description=?, category_id=?, img=? WHERE id=?");
    
            mysqli_stmt_bind_param($prep, "ssssi", $title, $desc, 
            $cat_id, $new_path, $id);
    
            mysqli_stmt_execute($prep);
        }else{
            $prep = mysqli_prepare($con, 
            "UPDATE blogs SET title=?, description=?, category_id=?
             WHERE id=?");
    
            mysqli_stmt_bind_param($prep, "sssi", $title, $desc, 
            $cat_id, $id);
    
            mysqli_stmt_execute($prep);
        }

       
        header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);
    }else{
        header("Location: $BASE_URL/editblog.php?error=23");
    }

?>