<?php
require_once('db.php');
session_start();
if(!isAuth()) header('Location: auth.php');

$id = $_GET['id'];

$data = mysqli_query($link, "SELECT * FROM photos WHERE id = $id");

$src = mysqli_fetch_array($data)['src'];

unlink($src);			//удаляем файл

mysqli_query($link, "DELETE FROM photos WHERE id = $id");	//удаляем фото

echo "Фото было успешно удалено! <br><br>";

echo "<a href = 'cabinet.php'>Личный кабинет</a>";

