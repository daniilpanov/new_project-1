<?php
use app\classes\Factory;

$id = $_GET['id'];
/** @var $vcontent \app\classes\Ccontent */
$vcontent = Factory::getClassInst("Ccontent");
$page = array();
$page = $vcontent->print_content($id);
?>
