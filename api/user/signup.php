<?php
    // $_POST = {
    //     email:"FGHJM<",
    //     nickname:"gbhnjmk,l",
    //     full_name:"fghjkl",
    //     password:"kk",
    //     password2:"kk"
    // }
    include "../../config/base_url.php";
    include "../../config/db.php";

    if(isset($_POST["email"], $_POST["nickname"], $_POST["full_name"],
    $_POST["password"], $_POST["password2"]) &&
    strlen($_POST["email"]) > 0 &&
    strlen($_POST["nickname"]) > 0 &&
    strlen($_POST["full_name"]) > 0 &&
    strlen($_POST["password"]) > 0 &&
    strlen($_POST["password2"]) > 0
    ){
        $email = $_POST["email"];
        $nickname = $_POST["nickname"];
        $full_name = $_POST["full_name"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];

        if($password != $password2){
            header("Location: $BASE_URL/register.php?error=2");
            exit();
        }

        // $query = mysqli_query($con, 
        // "SELECT * FROM users WHERE nickname=$nickname OR 1=1");

        $prep = mysqli_prepare($con, "SELECT * FROM users WHERE nickname=?");
        mysqli_stmt_bind_param($prep, "s", $nickname);
        mysqli_stmt_execute($prep);
        $q = mysqli_stmt_get_result($prep);
        
        if(mysqli_num_rows($q) > 0){
            header("Location: $BASE_URL/register.php?error=3");
            exit();
        }

        $hash = sha1($password);

        mysqli_query($con, 
        "INSERT INTO users (email, nickname, full_name, password)
        VALUES('$email', '$nickname', '$full_name', '$hash')");

        header("Location: $BASE_URL/login.php");

    }else{
        header("Location: $BASE_URL/register.php?error=1");
    }
?>