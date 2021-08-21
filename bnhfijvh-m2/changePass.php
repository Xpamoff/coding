<?php
require_once('db.php');
session_start();

if(!isAuth()) header('Location: auth.php');
?>
<form method = "POST">
Введите старый пароль:<br>
<input type = "password" name = "password" required><br><br>
Новый пароль:<br>
<input type = "password" name = "newPassword" required><br><br>
<input type = "submit" name = "change" value = "Изменить пароль"><br><br>
</form><br><br>
<?php

	if(isset($_POST['change'])){
		$password = $_POST['password'];
		$newPassword = $_POST['newPassword'];
		
		$login = $_SESSION['login'];
		
		if($_SESSION['password'] == $password){							//если введён верный пароль
			mysqli_query($link, "UPDATE users SET password = '$newPassword' WHERE login = '$login'");	//изменение пароля в бд
			
			$_SESSION['password'] = $newPassword;
			
			echo "Пароль успешно изменён!<br><br>";
		}
		else{
			echo "Ошибка! Неверный пароль!<br><br>";
		}
	}
?>

<a href = "cabinet.php">Личный кабинет</a>