<?php
require_once('db.php');
session_start();

if(!isAuth()) header('Location: auth.php');
?>
<a href = "upload.php">Загрузить фото</a><br><br>
<a href = "exit.php">Выход</a><br><br>
<a href = "changePass.php">Изменить пароль</a><br><br>
<a href = "index.php">Главная</a><br><br>
<?php

$login = $_SESSION['login'];
$password = $_SESSION['password'];

$data = mysqli_query($link, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");

$userId = mysqli_fetch_array($data)['id'];

$limitStart = isset($_GET['limitStart']) ? $_GET['limitStart'] : 0;

$data = mysqli_query($link, "SELECT * FROM photos WHERE user_id = '$userId'");

$photoCount = mysqli_num_rows($data);

$data = mysqli_query($link, "SELECT * FROM photos WHERE user_id = '$userId' LIMIT $limitStart, 6");		//получаем фото

while($photoData = mysqli_fetch_array($data)){								//вывод фото
PRINT <<< HERE
	<p>$photoData[title]</p>
	<a href = 'edit.php?id=$photoData[id]'>Редактировать</a><br><br>
	<a href = 'delete.php?id=$photoData[id]'>Удалить</a><br><br>
	<img src = '$photoData[src]' height = 300px width = 300px><br><br>
HERE;
	if($photoData['tags']){												//вывод тегов
		$tags = explode('#', $photoData['tags']);
		foreach($tags as $tag){
			echo "$tag ";
		}
	}
	echo "<br><br><br><br>";
}

if($limitStart - 6 >= 0) echo "<a href = 'cabinet.php?limitStart=".($limitStart-6)."'><<< Назад </a>";						
if($limitStart + 6 < $photoCount) echo "<a href = 'cabinet.php?limitStart=".($limitStart + 6)."'> Вперёд >>></a>";