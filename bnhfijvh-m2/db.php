<?php

$link = mysqli_connect("localhost", "bnhfijvh", "SY7k6e", "bnhfijvh_m2"); //подключение к бд

function isAuth(){ //проверка пользователя на авторизацию
	$link = mysqli_connect("localhost", "bnhfijvh", "SY7k6e", "bnhfijvh_m2");
	session_start();
	
	$login = $_SESSION['login'];
	$password = $_SESSION['password'];
	
	$data = mysqli_query($link, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");
	
	if(mysqli_num_rows($data)) return true;
	else return false;
}