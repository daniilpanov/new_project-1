<?php
//
use app\classes\Factory;
?>
<div class="container">
    <header>
        <div class="row">

            <div class="col-md-2 logotext">
                <img  alt="" src="upload/images/logo.png">
            </div>

            <div class="col-md-10">
                <h1 class="logotext"><?=SITE?></h1>
            </div>
        </div>
    </header>

    <div class="row">
        <div class="col-md-12">
            <div id="custom-bootstrap-menu" class="navbar navbar-default" role="navigation">
                <div class="container">

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"><?=MENU?></a>
                        </div>

                        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                            <?php
                            require_once 'views/vmenu.php';
                            ?>
                        </div><!--navbar-collapse -->

                </div><!--container-->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?php
            require_once 'views/vsidebarMenu.php';
            ?>
            <!--Настройки бокового меню-->
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#demo1').navgoco({
                        caretHtml: '<i class="some-random-icon-class"></i>',
                        accordion: false,
                        openClass: 'open',
                        save: true,
                        cookie: {
                            name: 'navgoco',
                            expires: false,
                            path: '/'
                          },
                        slide: {
                            duration: 400,
                            easing: 'swing'
                        }
                    });

                    $("#collapseAll").click(function(e) {
                        e.preventDefault();
                        $('#demo1').navgoco('toggle', false);
                    });

                    $("#expandAll").click(function(e) {
                        e.preventDefault();
                        $('#demo1').navgoco('toggle', true);
                    });
                });

            </script>

            <p class="external">
                <a href="#" id="expandAll"><?=OPEN?></a> | <a href="#" id="collapseAll"><?=CLOSE?></a>
            </p>
        </div>
        <div class="col-md-9">
            <div id="content_zone"><?php

                $test = Factory::getClassInst("TEST");

                // если от пользователя получен запрос на поиск по сайту
                if($_POST['search'])
                {
                    // подключаем соответствующий вид
                    require_once 'views/vsearch.php';
                }
                else
                {
                    echo $page['content'];
                    echo "<p>&nbsp;</p>";

                    if($_POST)
                    {
                        // Если пользователь отправил письмо
                        if (isset($_POST['mail_submit']))
                        {
                            /** @var $mail \app\classes\SendMail */
                            $mail = Factory::getClassInst("SendMail", false, [$_POST['from'], $_POST['subject'], $_POST['mess'], $_POST['phone'], $_FILES['attach']]);
                            $mail->send();
                        }
                        // А если пользователь отправил отзыв
                        elseif (isset($_POST['review_submit']))
                        {
                            $review = Factory::getClassInst("Creview");
                            $review->add_review($_POST);
                        }
                    }
                    // подключаем отзывы
                    if($page['reviews_visible'])
                    {
                        echo "<div id='reviews'>";
                        require_once 'views/vreview.php';
                        echo "</div>";
                    }
                    ?>
                    <hr>
                    <div id="additionally"><?
                        // подключаем форму для отзывов
                        if($page['reviews_add'])
                        {
                            require_once 'views/vreviewform.php';
                        }
                        // подключаем контакты
                        if ($page['contacts_visible'])
                        {
                            require_once "views/vcontactsform.php";
                        }
                        ?>
                    </div><?php
                }

                require_once "admin/js/bootstrap/carousel.js";
                require_once "admin/js/jquery/lightbox.ini.js";
                ?>
                <p class="pull-right">
                    <a href="#">
                        <button type="button" class="btn btn-custom"><i class="icon-angle-up icon-large"> </i></button>
                    </a>
                </p>
            </div>

        </div>
    </div>