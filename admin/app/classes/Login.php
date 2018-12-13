<?php
namespace app\classes;

class Login
{
	function clean_login($login)
	{
        $l = stripslashes($login);
        $l = htmlspecialchars($l);

        $l = trim($l);

        return $l;
	}
	
	function clean_password($password)
	{
        $p = stripslashes($password);
        $p = htmlspecialchars($p);

        $p = trim($p);

        $salt1="a153bd";
        $salt2="b3p6ft";
        $p = md5(md5($salt1).md5($p).md5($salt2));
        $p = strrev($p);

        return $p;
	}
	
    function return_authorisation()
	{
        $sql = "SELECT * FROM users WHERE id=1";
        $res = \app\classes\Db::getInstance()->sql($sql);// выполняем запрос
        return $res; // возвращаем результат
    }
}
?>