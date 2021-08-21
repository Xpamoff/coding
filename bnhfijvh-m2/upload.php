<?php
require_once('db.php');
session_start();

if(!isAuth()) header("Location: auth.php");
?>

<form method = "POST" enctype = "multipart/form-data">
Название изображения:<br>
<input type = "text" name = "title"><br><br>
Теги:<br>
<input type = "text" name = "tags"><br><br>
<input type = "file" name = "img" required><br><br>
<input type = "submit" name = "upload" value = "Загрузить фото"><br><br>
</form><br><br>

<?php

	if(isset($_POST['upload'])){
		
		$title = empty($_POST['title']) ? "DefaultImg" : $_POST['title'];
		
		$tags = empty($_POST['tags']) ? null : $_POST['tags'];
		
		$img = $_FILES['img'];

		$imgSize = $img['size'];					//размер изображения

		$maxSize = 1024*1024;

		$imgExtension = end(explode('.', $img['name']));				//расширение изображения
		
		if($imgSize && $imgSize <= $maxSize && ($imgExtension == 'png' || $imgExtension = 'jpg' || $imgExtension == 'jpeg')){	//проверка изображения
			
			do{
				$imgName = md5(microtime() . rand(0, 9999));
				$path = 'images/' . $imgName . '.png';
			}while(file_exists($path));											//генерация имени файла
			
			$size = getimagesize($img['tmp_name']);
			
			$size = min($size[0], $size[1]);
			
			$img = imagecrop(imagecreatefromstring(file_get_contents($img['tmp_name'])), ["x"=>0,"y"=>0,"width"=>$size,"height"=>$size]); //Обрезка изображения
			
			
			imagepng($img, $path);		//сохранение изображения на сервере
			
			$login = $_SESSION['login'];
			$password = $_SESSION['password'];
			
			$data = mysqli_query($link, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");
			
			$userId = mysqli_fetch_array($data)['id'];
			
			mysqli_query($link, "INSERT INTO photos (title, tags, src, user_id) VALUES('$title', '$tags', '$path', '$userId')");	//сохранение изображения в бд
			
			echo "Фото успешно загружено!<br><br>";
		}
		else{
			echo "Ошибка! Неподходящий файл!<br><br>";
		}
	}
?>

<a href = "cabinet.php">Личный кабинет</a><br><br>