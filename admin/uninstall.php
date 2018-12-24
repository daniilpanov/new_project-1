<?php
session_start();
ini_set("error_reporting", "1");

// автозагрузка классов
spl_autoload_register(function ($name)
{
    // конвертируем полный путь в пространстве имён с \ в /
    $name = str_replace('\\', '/', $name);

    require_once($name.'.php');
});

$uninstall = \app\classes\Uninstall::getInstance();
$content = "";

$header = "
<i class='icon-spinner icon-spin'></i>
Uninstalling...";

$del = false;

if (!$_POST['password'])
{
    $content = $uninstall->getForm();
}
else
{
    $res = $uninstall->checkPassword($_POST['password']);

    if ($res)
    {
        $uninstall->progress++;
        if ($del = $uninstall->delete())
        {
            $header = "
            <i class='icon-check'></i>
            Вся информация с Вашего сайта удалена!
            ";
        }
    }
    else
    {
        $content = $uninstall->getForm();
        $content .= $uninstall->getErrorMessage();
    }
}
?>
<html lang="<?=$_SESSION['language']?>">
<head>
    <title>
        <?=$uninstall->getTitle()?>
    </title>

    <!--CSS-->
    <link href="style/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="style/jquery.lightbox-0.5.css" rel="stylesheet" />
    <!--End CSS-->

    <!--Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Marck+Script&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!--End Fonts-->

    <!--Favicon-->
    <link rel="shortcut icon" href="../favicon.ico" />
    <!--End Favicon-->

    <!--Java scripts-->
    <script type="text/javascript" src="js/jquery/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="js/jquery/jquery.lightbox-0.5.js"></script>
    <!--End Java scripts-->

    <!--bootstrap-->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!--End Bootstrap-->
</head>
<body style="text-align: center">
<div class="container">
    <div class="jumbotron">
        <h2>
            <?=$header?>
        </h2>
    </div>
    <p>
        <?php
        echo $content;

        if ($del)
        {
            $uninstall->progress++;
            ?>
            <script>
                document.getElementsByTagName("title")[0].innerHTML = "<?=$uninstall->getTitle()?>"
            </script>
            <?php
        }
        ?>
    </p>
</div>
</body>
</html>
