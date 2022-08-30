<?php
    include "../../config/base_url.php";
    include "../../config/db.php";
    session_start();
    if(isset($_GET["id"])){
        mysqli_query($con, "DELETE FROM blogs WHERE id=".$_GET["id"]);
        header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);
    }else{
        header("Location: $BASE_URL/profile.php?error=22&nickname=".$_SESSION["nickname"]);
    }
?>