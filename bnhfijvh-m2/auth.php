<?php
require_once('db.php');
session_start();
if(isAuth()) header("Location: cabinet.php");
?>
<form method = "POST">
Логин:<br>
<input type = "text" name = "login" required><br><br>
Пароль:<br>
<input type = "password" name = "password" required><br><br>

<input type = "submit" name = "auth" value = "Войти"><br><br>
</form><br><br>

<?php

	if(isset($_POST['auth'])){
		
		$login = $_POST['login'];
		
		$password = $_POST['password'];
		
		$_SESSION['login'] = $login;
		$_SESSION['password'] = $password;
		
		if(isAuth()) echo "Вы успешно авторизовались!<br><br><a href = 'cabinet.php'>Перейти в личный кабинет</a><br><br>";
		else echo "Ошибка! Введены неверные данные!<br><br>";
	}


?>

<a href = "reg.php">Регистрация</a><br><br>
<a href = "index.php">Главная</a><br><br>