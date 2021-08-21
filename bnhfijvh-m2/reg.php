<?php
require_once('db.php');
if(isAuth()) header("Location: cabinet.php");
?>
<form method = "POST">
Имя:<br>
<input type = "text" name = "name" required><br><br>
Фамилия:<br>
<input type = "text" name = "surname" required><br><br>
Номер телефона:<br>
<input type = "text" name = "login" required><br><br>
Пароль:<br>
<input type = "password" name = "password" required><br><br>
Подтверждение пароля:<br>
<input type = "password" name = "confirmPassword" required><br><br>
<input type = "submit" name = "reg" value = "Зарегистрироваться"><br><br>
</form><br><br>

<?php

	if(isset($_POST['reg'])){
		$surname = $_POST['surname'];
		
		$name = $_POST['name'];
		
		$login = $_POST['login'];
		
		$password = $_POST['password'];
		
		$confirmPassword = $_POST['confirmPassword'];
		if($password != $confirmPassword) echo "Ошибка!Пароли не совпадают<br><br>";																	//валидация
		elseif(strlen($login) != 11) echo "Ошибка! Номер телефона должен содержать 11 цифр<br><br>";
		elseif(strlen($password) < 6) echo "Ошибка! Пароль должен содержать не меньше 6 символов";
		elseif(!preg_match('/[а-я]/i', $name) || !preg_match('/[а-я]/i', $surname)) echo "Ошибка! имя и фамилия должны состоять из кириллицы<br><br>";
		elseif(!preg_match('/[a-z]/', $password)) echo "Ошибка! Пароль должен содержать минимум 1 символ нижнего регистра";
		elseif(!preg_match('/[A-Z]/', $password)) echo "Ошибка! Пароль должен содержать хотя бы один символ верхнего регистра<br><br>";
		elseif(!preg_match('/[0-9]/', $password)) echo "Ошибка! Пароль должен содержать хотя бы одну цифру<br><br>";
		elseif(!strpbrk($password, "!_-#")) echo "Ошибка! Пароль должен содержать хотя бы один спецсимвол<br><br>";
		else{
			$data = mysqli_query($link, "SELECT * FROM users WHERE login = '$login'");

			if(mysqli_num_rows($data)) echo "Ошибка! Пользователь с таким номером телефона уже зарегистрирован<br><br>";			//проверка номера телефона на уникальность
			else{
				mysqli_query($link, "INSERT INTO users(name, surname, login, password) VALUES('$name', '$surname', '$login', '$password')");	//сохранение пользователя в бд
				
				echo "Вы успешно зарегистрировались!<br><br>";
			}
		}
	}


?>

<a href = "auth.php">Авторизация</a><br><br>
<a href = "index.php">Главная</a><br><br>