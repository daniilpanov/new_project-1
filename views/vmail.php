<?php
spl_autoload_register(function ($name)
{
   require_once('../'.$name.'.php');
});

if($_POST['submit'])
{
    $send = \app\classes\Factory::getClassInst("SendMail");
    $send->setNewMail($_POST['from'],$_POST['subject'],$_POST['mess'],$_POST['phone']);
    $send->send();
}
?>