<?php
    require_once "inition.php";
    $connect = new connect();
    $link = $connect->con();
    $isAuth = isAuth();
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $login = $_POST['login'];
        $surname = $_POST['surname'];
        $password = $_POST['password'];
        reg($login, $password, $name, $surname);
        auth($login, $password);
        header("Location: index.php");
    }
    if(isset($_POST['submit1'])){
        $login = $_POST['login1'];
        $password = $_POST['password1'];
        $res_auth = auth($login, $password);
        if($res_auth){
            header("Location: index.php");
        }
        else{
            echo 'Неверный логин или пароль';
        }
    }
    if(isset($_POST['quit'])){
        quit();
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    if($isAuth){
        $res = getUserInfo($_SESSION['login'], $_SESSION['password']);
        echo '<div>Вы вошли как: '.$res['name'].' '.$res['surname'].'</div>';
        echo '<form method="post"><input type="submit" name="quit" value="Выйти"></form>';
        echo '<div class="hid">';
    }
    else{
        echo '<div class="vid">';
    }
?>
        Регистрация
        <form method="post">
            <input type="text" placeholder="Имя" name="name" required>
            <input type="text" placeholder="Фамилия" name="surname" required>
            <input type="text" placeholder="Логин" name="login" required>
            <input type="password" placeholder="Пароль" name="password" required>
            <input type="submit" name="submit" value="Зарегистрироваться" required>
        </form>
        Авторизация
        <form method="post">
            <input type="text" placeholder="Логин" name="login1" required>
            <input type="password" placeholder="Пароль" name="password1" required>
            <input type="submit" name="submit1" value="Войти" required>
        </form>
    </div>
    <div class="add <?php if(!$isAuth) echo 'hid'; ?>">
        <a href="add.php">Добавить запись</a>
    </div>
    <div class="posts">
        <h3>Последние посты:</h3>
        <?php
            $posts_tmp = mysqli_query($link, 'SELECT * FROM `posts` ORDER BY id DESC');
            while($post = mysqli_fetch_array($posts_tmp)){
                echo '<h4>'.$post['name'].'</h4>';
                echo '<h6>Автор: '.$post['user_name'].'</h6>';
                echo '<img src="'.$post['photo'].'">';
                echo '<div>Краткое описание: '.$post['article'].'</div>';
                echo '<a href="single.php?id='.$post['id'].'">Узнать подробнее</a>';
            }
        ?>
    </div>
</body>
</html>