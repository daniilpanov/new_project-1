<?php

if (!isset($_POST['user']) || !isset($_POST['pass0']) || !isset($_POST['pass1']) || !isset($_POST['pass2']))
{
?>

<form method="post">
   <p>
    <table class="table_page_list">
    <tr><td class="table_header">Изменить логин/пароль администратора сайта</td><td class="header_td"></td></tr>
    <tr><td class="text_align_left">Введите старый логин или задайте новый:</td><td><input  type="text" name="user" id="user" /></td></tr>
    <tr><td class="text_align_left">Введите текущий пароль:</td><td><input  type="password" name="pass0" id="pass0" /></td></tr>
    <tr><td class="text_align_left">Введите новый пароль:</td><td><input  type="password" name="pass1" id="pass1" /></td></tr>
    <tr><td class="text_align_left">Введите новый пароль еще раз:</td><td><input  type="password" name="pass2" id="pass2" /></td></tr>
	<tr><td class="text_align_left"><input type="submit" name="changeauth" value="Изменить" /></td></tr>
    </table>
  </p>
</form>

<?php
}
else
{
	$user  = $_POST['user'];
	$pass0 = $_POST['pass0'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	if (empty($user) || empty($pass0) || empty($pass1) || empty($pass2))
	{
			exit ("<center><img src='image/error.png' border=0><h4><h4>Вы ввели не всю информацию, вернитесь назад и заполните все поля!</h4><br><a href='?page=changeauth'>попытаться еще раз</a></center>");
	}


	$changeauth = new \app\classes\MchangeAuth();

	$user = $changeauth->clean_login($user);
	$pass0 = $changeauth->clean_password($pass0);
	$pass1 = $changeauth->clean_password($pass1);
	$pass2 = $changeauth->clean_password($pass2);

	$result = $changeauth->return_authorisation();
	$myrow = mysqli_fetch_array($result);
	$dbpass = $myrow['password'];
	
	if ($dbpass == $pass0 && $pass1 == $pass2)
	{
		$result = $changeauth->change_authentification($user,$pass1);
	}
	else
	{			
		echo "<center><img src='image/error.png' border=0><h4>Вы допустили ошибку при заполнении, вернитесь назад и попробуйте еще раз!</h4><br><a href='?page=changeauth'>попытаться еще раз</a></center>";
	}
}	
?>