<?php
require_once('db.php');
session_start();

if(!isAuth()) header('Location: auth.php');
?>


<form method = "POST">
Название изображения:<br>
<input type = "text" name = "title"><br><br>
Теги:<br>
<input type = "text" name = "tags"><br><br>
<input type = "submit" name = "upload" value = "Изменить фото"><br><br>
</form><br><br>

<?php

	if(isset($_POST['upload'])){
		
		$id = $_GET['id'];

		$title = empty($_POST['title']) ? null : $_POST['title'];
		
		$tags = empty($_POST['tags']) ? null : $_POST['tags'];
		if(!$title && !$tags) echo "Введены неверные данные!<br><br>";
		else{
			
			if($title) mysqli_query($link, "UPDATE photos SET title = '$title' WHERE id = $id");	//редактируем название
			if($tags) mysqli_query($link, "UPDATE photos SET tags = '$tags' WHERE id = $id");		//редактируем теги
			
			
			
			echo "Фото успешно изменено!<br><br>";
		}
	}
?>

<a href = "cabinet.php">Личный кабинет</a><br><br>