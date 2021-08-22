<?php
    require_once "inition.php";
    $isAuth = isAuth();
    if(!$isAuth) header("Location: index.php");
    if(isset($_POST['submit'])){
        $file = $_FILES['photo'];
        $ext_tmp = explode('.', $file['name']);
        $ext = end($ext_tmp);
        $photo = 'img/'.time().'.'.$ext;
        copy($file['tmp_name'], $photo);
        $user = getUserInfo($_SESSION['login'], $_SESSION['password']);
        addNote($user['id'], $_POST['name'], $_POST['article'], $_POST['text'], $photo, $user['name'].' '.$user['surname']);
        header("Location: index.php");
    }
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Добавление записи
    <form method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Название" name="name" required>
        <input type="text" placeholder="Краткое описание" name="article" required>
        <input type="text" placeholder="Текст" name="text" required>
        <input type="file" placeholder="Фото" name="photo" required>
        <input type="submit" name="submit" value="Добавить" required>
    </form>
</body>
</html>
