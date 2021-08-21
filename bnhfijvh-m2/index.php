<?php
require_once('db.php');
session_start();
if(isAuth()) echo "<a href = 'cabinet.php'>Личный кабинет</a><br><br>";
else{
	echo "<a href = 'auth.php'>Авторизация</a><br><br>";
	echo "<a href = 'reg.php'>Регистрация</a><br><br>";
}
?>

<form method = "POST">
Введите часть тэга или названия изображения (не меньше 3 символов)<br>
<input type = "text" name = "query" required><br><br>
<input type = "submit" name = "search" value = "Искать"><br><br>
</form>

<?php

if(isset($_POST['query']) || isset($_GET['query'])){
	
	$query = isset($_GET['query']) ? $_GET['query'] : $_POST['query'];
	if(strlen($query) < 3) echo "Ошибка! Слишком короткий запрос!<br><br>";			//проверка длины запроса
	else{
	if(isAuth()){
		$login = $_SESSION['login'];
		$password = $_SESSION['password'];

		$data = mysqli_query($link, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");

		$userId = mysqli_fetch_array($data)['id'];
	}
	else{
		$userId = "id";
	}
	$limitStart = isset($_GET['limitStart']) ? $_GET['limitStart'] : 0;

	$data = mysqli_query($link, "SELECT * FROM photos WHERE user_id != $userId AND (title LIKE '%$query%' OR tags LIKE '%$query%')");

	$photoCount = mysqli_num_rows($data);

	$data = mysqli_query($link, "SELECT * FROM photos WHERE user_id != $userId AND (title LIKE '%$query%' OR tags LIKE '%$query%') LIMIT $limitStart, 6");

	while($photoData = mysqli_fetch_array($data)){				//вывод фото
PRINT <<< HERE
		<p>$photoData[title]</p>
		<img src = '$photoData[src]' height = 300px width = 300px><br><br>
HERE;
		if($photoData['tags']){
			$tags = explode('#', $photoData['tags']);		//вывод тегов
			foreach($tags as $tag){
				echo "$tag ";
			}
		}
		echo "<br><br><br><br>";
	}

	if($limitStart - 6 >= 0) echo "<a href = 'index.php?query=$query&limitStart=".($limitStart-6)."'><<< Назад </a>";
	if($limitStart + 6 < $photoCount) echo "<a href = 'index.php?query=$query&limitStart=".($limitStart + 6)."'> Вперёд >>></a>";
	
	
}
}