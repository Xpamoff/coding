<?php
    session_start();
    $link = mysqli_connect('localhost', 'root', '', 'blog');

    function isAuth(){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        if(isset($_SESSION['password']) && isset($_SESSION['login'])){
            $res_tmp = mysqli_query($link, 'SELECT * FROM `users` WHERE login = "'.$_SESSION['login'].'" AND password = "'.$_SESSION['password'].'"');
            if(mysqli_num_rows($res_tmp)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    function getUserInfo($login, $password){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        $res_tmp = mysqli_query($link, 'SELECT * FROM `users` WHERE login = "'.$login.'" AND password = "'.$password.'"');
        $res = mysqli_fetch_array($res_tmp);
        return $res;
    }
    function auth($login, $password){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        $res_tmp = mysqli_query($link, 'SELECT * FROM `users` WHERE login = "'.$login.'" AND password = "'.$password.'"');
        if(mysqli_num_rows($res_tmp)){
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            return true;
        }
        else{
            return false;
        }
    }
    function reg($login, $password, $name, $surname){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        mysqli_query($link, "INSERT INTO `users`(`name`, `surname`, `login`, `password`) VALUES ('".$name."','".$surname."','".$login."','".$password."')");
    }
    function quit(){
        $_SESSION['password'] = "";
        $_SESSION['login'] = "";
        header("Location: index.php");
    }
    function addNote($userId, $name, $article, $text, $photo, $user_name){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        mysqli_query($link, "INSERT INTO `posts`(`user_id`, `name`, `article`, `text`, `photo`, `user_name`) VALUES ('".$userId."','".$name."','".$article."','".$text."','".$photo."','".$user_name."')");
    }
    function getPostInfo($id){
        $link = mysqli_connect('localhost', 'root', '', 'blog');
        $res_tmp = mysqli_query($link, 'SELECT * FROM `posts` WHERE id="'.$id.'"');
        $res = mysqli_fetch_array($res_tmp);
        return $res;
    }
    class connect{
        public function con(){
            $link = mysqli_connect('localhost', 'root', '', 'blog');
            return $link;
        }
    }