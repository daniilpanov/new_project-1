<?php
/**
 * @filename install.php
 * создание таблиц и заполнение первоначальными данными
 * @author Клуб интеллектуалов
 * @copyright 01.04.2014
 * @updated 28.12.2017
 */

session_start();

// автозагрузка классов
spl_autoload_register(function ($name)
{
    // конвертируем полный путь в пространстве имён с \ в /
    $name = str_replace('\\', '/', $name);

    require_once($name.'.php');
});
if ($_POST)
{
    $_SESSION['domain_name'] = $_POST['domain_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['db_server_address'] = $_POST['db_server_address'];
    $_SESSION['db_database_name'] = $_POST['db_database_name'];
    $_SESSION['db_user_name'] = $_POST['db_user_name'];
    $_SESSION['db_user_password'] = $_POST['db_user_password'];
    $_SESSION['admin_login'] = $_POST['admin_login'];
}

?>
    <!DOCTYPE html>
    <html lang="ru">

    <head>

        <!--Meta-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <!--End Meta-->

        <title>Установка...</title>

        <!--CSS-->
        <link href="style/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="style/install.css" rel="stylesheet" />
        <!--End CSS-->

        <!--Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Marck+Script&subset=latin, cyrillic' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <!--End Fonts-->

        <!--Favicon-->
        <link rel="shortcut icon" href="favicon.ico" />
        <!--End Favicon-->

        <!--Java scripts-->
        <script type="text/javascript" src="admin/js/jquery/jquery-1.11.3.js"></script>
        <script type="text/javascript" src="admin/js/jquery/jquery.cookie.js"></script>
        <!--End Java scripts-->

        <!--Bootstrap-->
        <script src="admin/js/bootstrap/bootstrap.min.js"></script>
        <!--End Bootstrap-->

    </head>

<body>
    
<?php

// если впервые запущена установка рисуем форму
if(!$_POST['domain_name'])
{
    ?>
        <div class="container">
            <div id="parent">
                <div id="child">
                    <form class="form-inline" method="post">

                        <h4>Название вашего домена</h4>
                        <div class="form-group" >
                            <label class="sr-only" for="domain_name">Название домена</label>
                            <input
                                    type="text" class="form-control"  id="domain_name"
                                    placeholder="http://domainname" name="domain_name"
                                    value="<?=$_SESSION['domain_name']?>" required>
                        </div>

                        <h4>Адрес электронной почты для формы обратной связи</h4>
                        <div class="form-group" >
                            <label class="sr-only" for="admin_mail">E-Mail</label>
                            <input
                                    type="text" class="form-control"  id="admin_mail"
                                    placeholder="e-mail" name="email" value="<?=$_SESSION['email']?>" required>
                        </div>

                        <h4>Настройки для подключения к серверу БД</h4>
                        <div class="form-group">
                            <label class="sr-only" for="db_server_address">Адрес сервера БД</label>
                            <input type="text" class="form-control" id="db_server_address"
                                   placeholder="адрес сервера БД" name="db_server_address"
                                   value="<?=$_SESSION['db_server_address']?>" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="db_database_name">Название БД</label>
                            <input type="text" class="form-control" id="db_database_name"
                                   placeholder="название БД" name="db_database_name"
                                   value="<?=$_SESSION['db_database_name']?>" required>
                        </div>

                        <br>
                        <div class="form-group">
                            <label class="sr-only" for="db_user_name">имя пользователя</label>
                            <input type="text" class="form-control" id="db_user_name"
                                   placeholder="имя пользователя" name="db_user_name"
                                   value="<?=$_SESSION['db_user_name']?>" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="db_user_password">пароль</label>
                            <input type="password" class="form-control" id="db_user_password"
                                   placeholder="пароль" name="db_user_password"
                                   value="<?=$_SESSION['db_user_password']?>" required>
                        </div>

                        <br>

                        <h4>Настройки входа в зону администрирования</h4>
                        <div class="form-group">
                            <label class="sr-only" for="admin_login">Логин</label>
                            <input type="text" class="form-control" id="admin_login"
                                   placeholder="Придумайте логин" name="admin_login"
                                   value="<?=$_SESSION['admin_login']?>" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="admin_password">Пароль</label>
                            <input type="password" class="form-control" id="admin_password"
                                   placeholder="Придумайте пароль" name="admin_password" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="repeat_password">Повторите пароль</label>
                            <input type="password" class="form-control" id="repeat_password"
                                   placeholder="Повторите пароль" name="repeat_password" required>
                        </div>

                        <br>
                        <input type="submit" class="btn btn-primary" value="Далее">
                    </form>
                </div>
            </div>
        </div>
    <?php
    die();
}

// если пароли не совпадают
if ($_POST['admin_password'] != $_POST['repeat_password'])
{
    die("<div class='alert alert-danger alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            Вы не повторили пароль!
            <strong><a href='' style='color: #a94442'>Ещё раз</a></strong>
        </div>");
}
// Копируем Login.php
copy("admin/app/classes/Login.php", "app/classes/Login.php");
/**
 * преобразуем логин и пароль
 * @var \app\classes\Login $prepared_authorization
 */
$prepared_authorization = \app\classes\Factory::getClassInst("Login");

$domain_name = $_POST['domain_name'];
$email = $_POST['email'];
$db_server_address = $_POST['db_server_address'];
$db_database_name = $_POST['db_database_name'];
$db_user_name = $_POST['db_user_name'];
$db_user_password = $_POST['db_user_password'];

$admin_login = $prepared_authorization->clean_login($_POST['admin_login']);
$admin_password = $prepared_authorization->clean_password($_POST['admin_password']);

// проверяем заполнил ли пользователь все поля
if (
    empty($domain_name)
    || empty($email)
    || empty($db_server_address)
    || empty($db_database_name)
    || empty($db_user_name)
    || empty($db_user_password)
    || empty($admin_login)
    || empty($admin_password))
{
    die("Вы ввели не всю необходимую информацию <a href='install.php'>Попробовать еще раз</a>");
}

// генерируем текст файла настроек для подключения к БД
$file_contents = "<?php
namespace app\classes;
 
class Config
{
\t const DB_HOST = \"";
     $file_contents .= $db_server_address;
     $file_contents .= "\"; // адрес сервера БД
\t const DB_USER = \"";
     $file_contents .= $db_user_name;
     $file_contents .= "\"; // имя пользователя 
\t const DB_PASS = \"";
     $file_contents .= $db_user_password;
     $file_contents .= "\"; // пароль пользователя
\t const DB_NAME = \"";
     $file_contents .= $db_database_name;
     $file_contents .= "\"; // название БД
\t const SQLCHARSET = \"utf8\"; // кодировка БД
}";

// напишем функцию для создания файла
function create_db_settings_file($file_path, $contents){
    if (!file_exists($file_path))
    {
        $handle = fopen($file_path, "w");
        fwrite($handle, "");

        fclose($handle);
    }

    if (filesize($file_path)==0)
    {
        $handle = fopen($file_path, "w");
        fwrite($handle, $contents);

        fclose($handle);
    }
}

// задаем имя файлов настроек которые необходимо создать
define('MYNAME', 'app/classes/Config.php');
define('MYNAME2', 'admin/app/classes/Config.php');

// Содержимое с настройками php
$htaccess = "AddDefaultCharset UTF-8

#Если страница не существует
ErrorDocument 404 {$domain_name}/404.php

#Отключаем magic_quotes_gpc
php_flag magic_quotes_gpc Off
php_flag magic_quotes_runtime Off
php_value register_globals Off

#Отключаем сообщения типа warning и notice
php_value error_reporting 1

#Включаем поддержку коротких тегов
php_flag short_open_tag on";

// создадим эти файлы
create_db_settings_file(MYNAME, $file_contents);
create_db_settings_file(MYNAME2, $file_contents);
create_db_settings_file(".htaccess", $htaccess);


// ПОДГОТОВИМ ЗАПРОСЫ ДЛЯ СОЗДАНИЯ НОВЫХ ТАБЛИЦ:
// структура таблицы 'constants'
$constants = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `constants` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  `domainname` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `reviews_on_page` int(4) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `reviews_neighbor_links` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// структура таблицы 'languages'
$languages = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `default_lng` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// структура таблицы 'menus'
$menus = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `position` int(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `header_visible` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// структура таблицы 'pages'
$pages = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(3) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `menu_icon` varchar(255) NOT NULL,
  `icon_size` varchar(255) NOT NULL,
  `menu_number` int(4) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `language` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `visible_in_main_menu` enum('0','1') NOT NULL,
  `visible_in_sidebar` enum('0','1') NOT NULL,
  `active_link_in_sidebar` enum('0','1') NOT NULL,
  `reviews_visible` enum('0','1') NOT NULL,
  `reviews_add` enum('0','1') NOT NULL,
  `contacts_visible` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// структура таблицы 'reviews'
$reviews = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `page_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `autor` varchar(255) NOT NULL,
  `visible` enum('0','1') NOT NULL,
  `state` varchar(255) NOT NULL,
  `created` int(255) NOT NULL,
  `lastmod` int(255) NOT NULL,
  `rating` int(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// структура таблицы 'users'
$users = /** @lang  MySQL */ "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";

// Подключаемся к БД
$mydbobj = \app\classes\Db::getInstance();

// создаем таблицы в существующей БД
echo "<div class='row'><div class='col-md-10'>Создаем таблицы в базе данных ".$db_database_name."</div>";
if (
    $mydbobj->sql($constants)
    && $mydbobj->sql($languages)
    && $mydbobj->sql($menus)
    && $mydbobj->sql($pages)
    && $mydbobj->sql($reviews)
    && $mydbobj->sql($users)
)
{
    echo "<div class='col-md-2'>OK</div></div>";
}
else
{
    echo "<div class='col-md-2'>Ошибка при создании таблиц</div></div>";
}

// подготовим дампы данных созданных таблиц

$dt = time(); // текущая метка времени

    // constants
    $add_constants = /** @lang MySQL */ "INSERT INTO
                    constants(language, domainname, site, footer, reviews_on_page, admin_email, reviews_neighbor_links)
                    VALUES(:lng, :domain, :site_name, :footer, :reviews_on_page, :admin_email, :neighbor)";

    // languages
    $add_language = /** @lang MySQL */ "INSERT INTO
                    languages(language, title, visible, default_lng)
                    VALUES(:lng, :title, :vis, :def_lng)";

    // menus
    $add_menu = /** @lang MySQL */ "INSERT INTO
                menus(id, menu_name, position, language, created, visible, header_visible)
                VALUES(:id, :name, :pos, :lng, :created, :vis, :header_vis)";

    // pages
    $add_page_1 = /** @lang MySQL */ "INSERT INTO
                pages(id, language, menu_icon, icon_size, menu_number, menu_name,
                 position, visible, visible_in_main_menu, visible_in_sidebar,
                  content, created, title, active_link_in_sidebar, reviews_visible, reviews_add, contacts_visible)
                VALUES(:id, :lng, :icon, :icon_size, :menu_number, :name, :pos, :vis, :vis_in_main, :vis_in_sidebar, :content, :created, :title, :link, :rev_vis, :rev_add, :contacts_vis)";
    
    $add_page_2 = /** @lang MySQL */ "INSERT INTO
                pages(id, parent_id, language, menu_number, menu_icon, icon_size, menu_name, position, visible,
                 visible_in_main_menu, visible_in_sidebar, content, created,
                  title, active_link_in_sidebar, reviews_visible, reviews_add, contacts_visible)
                VALUES(:id, :parent_id, :lng, :menu_number, :menu_icon, :icon_size, :name, :pos, :vis, :vis_in_main, :vis_in_sidebar, :content, :created, :title, :link, :rev_vis, :rev_add, :contacts_vis)";

    // reviews
    $add_review = /** @lang MySQL */ "INSERT INTO
                reviews(page_id, name, review, autor, visible, state, created, rating, email)
                VALUES(:page_id, :name, :rev, :autor, :vis, :state, :created, :rating, :email)";

    // users
    $adduser = /** @lang MySQL */ "INSERT INTO users(login, password) VALUES(:login, :password)";



// добавляем данные в созданные таблицы
echo "<div class='row'><div class='col-md-10'>Добавляем первоначальные данные в созданные таблицы</div>";
if(
    $mydbobj->sql(
            $add_constants,
            ['lng' => 'ru', 'domain' => $domain_name,
                'site_name' => 'Название Сайта', 'footer' => 'Не является публичной офертой',
                'reviews_on_page' => '3', 'admin_email' => $email, 'neighbor' => '2']
    )
    && $mydbobj->sql(
            $add_constants,
            ['lng' => 'en', 'domain' => $domain_name,
                'site_name' => 'Site name', 'footer' => 'Not a public offer',
                'reviews_on_page' => '3', 'admin_email' => $email, 'neighbor' => '2']
    )
    && $mydbobj->sql(
            $add_language,
            ['lng' => 'ru', 'title' => 'русский',
                'vis' => '1', 'def_lng' => '1']
    )
    && $mydbobj->sql(
            $add_language,
            ['lng' => 'en', 'title' => 'english',
                'vis' => '1', 'def_lng' => '0']
    )
    && $mydbobj->sql(
            $add_menu,
            ['id' => '1', 'name' => 'Мы предлагаем',
                'pos' => '1', 'lng' => 'ru', 'created' => $dt,
                'vis' => '1', 'header_vis' => '1']
    )
    && $mydbobj->sql(
            $add_menu,
            ['id' => '2', 'name' => 'We offer',
                'pos' => '2', 'lng' => 'en', 'created' => $dt,
                'vis' => '1', 'header_vis' => '1']
    )
    && $mydbobj->sql(
            $add_page_1,
            ['id' => '1', 'lng' => 'ru', 'icon' => 'icon-home', 'icon_size' => 'icon-large',
                'menu_number' => '1', 'name' => 'Главная', 'pos' => '1', 'vis' => '1',
                'vis_in_main' => '1', 'vis_in_sidebar' => '1', 'content' => 'Главная', 'created' => $dt,
                'title' => 'адрес сайта | Ключевое слово | Главная', 'link' => '1',
                'rev_vis' => '1', 'rev_add' => '0', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
            $add_page_1,
            ['id' => '2', 'lng' => 'en', 'icon' => 'icon-home', 'icon_size' => 'icon-large',
                'menu_number' => '2', 'name' => 'Main', 'pos' => '3', 'vis' => '1',
                'vis_in_main' => '1', 'vis_in_sidebar' => '1', 'content' => 'Main',
                'created' => $dt, 'title' => 'site address | Keyword | Main', 'link' => '1',
                'rev_vis' => '1', 'rev_add' => '0', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
            $add_page_1,
            ['id' => '5', 'lng' => 'ru', 'icon' => 'icon-comments', 'icon_size' => 'icon-large',
                'menu_number' => '0', 'name' => 'Отзывы', 'pos' => '5', 'vis' => '1',
                'vis_in_main' => '1', 'vis_in_sidebar' => '0', 'content' => '',
                'created' => $dt, 'title' => 'адрес сайта | Ключевое слово | Отзывы', 'link' => '1',
                'rev_vis' => '1', 'rev_add' => '1', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
        $add_page_1,
        ['id' => '6', 'lng' => 'ru', 'icon' => 'icon-envelope', 'icon_size' => 'icon-large',
            'menu_number' => '0', 'name' => 'Контакты', 'pos' => '6', 'vis' => '1',
            'vis_in_main' => '1', 'vis_in_sidebar' => '0', 'content' => '',
            'created' => $dt, 'title' => 'адрес сайта | Ключевое слово | Контакты', 'link' => '1',
            'rev_vis' => '0', 'rev_add' => '0', 'contacts_vis' => '1']
    )
    && $mydbobj->sql(
        $add_page_1,
        ['id' => '7', 'lng' => 'en', 'icon' => 'icon-comments', 'icon_size' => 'icon-large',
            'menu_number' => '0', 'name' => 'Reviews', 'pos' => '6', 'vis' => '1',
            'vis_in_main' => '1', 'vis_in_sidebar' => '0', 'content' => '',
            'created' => $dt, 'title' => 'site address | Keyword | Reviews', 'link' => '1',
            'rev_vis' => '1', 'rev_add' => '1', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
        $add_page_1,
        ['id' => '8', 'lng' => 'en', 'icon' => 'icon-envelope', 'icon_size' => 'icon-large',
            'menu_number' => '0', 'name' => 'Contacts', 'pos' => '7', 'vis' => '1',
            'vis_in_main' => '1', 'vis_in_sidebar' => '0', 'content' => '',
            'created' => $dt, 'title' => 'site address | Keyword | Contacts', 'link' => '1',
            'rev_vis' => '0', 'rev_add' => '0', 'contacts_vis' => '1']
    )
    && $mydbobj->sql(
            $add_page_2,
            ['id' => '3', 'parent_id' => '1', 'lng' => 'ru', 'menu_number' => '1',
                'icon' => 'icon-briefcase', 'icon_size' => 'icon-large',
                'name' => 'Пример страницы', 'pos' => '2', 'vis' => '1',
                'vis_in_main' => '0', 'vis_in_sidebar' => '1', 'content' => 'Пример страницы',
                'created' => $dt, 'title' => 'адрес сайта | Ключевое слово | Пример страницы',
                'link' => '1', 'rev_vis' => '1', 'rev_add' => '0', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
            $add_page_2,
            ['id' => '4', 'parent_id' => '2', 'lng' => 'en', 'menu_number' => '2',
                'icon' => 'icon-briefcase', 'icon_size' => 'icon-large',
                'name' => 'Example page', 'pos' => '4', 'vis' => '1',
                'vis_in_main' => '0', 'vis_in_sidebar' => '1', 'content' => 'Example page',
                'created' => $dt, 'title' => 'site address | Keyword | Example page',
                'link' => '1', 'rev_vis' => '1', 'rev_add' => '0', 'contacts_vis' => '0']
    )
    && $mydbobj->sql(
            $add_review,
            ['page_id' => '5', 'name' => 'Первый отзыв',
                'rev' => 'Очень хороший отзыв',
                'autor' => 'Администратор сайта', 'vis' => '1', 'state' => 'good',
                'created' => $dt, 'rating' => '5', 'email' => 'clubintellect@mail.ru']
    )
    && $mydbobj->sql(
            $add_review,
            ['page_id' => '7', 'name' => 'First review',
                'rev' => 'Very good review',
                'autor' => 'Site administrator', 'vis' => '1', 'state' => 'good',
                'created' => $dt, 'rating' => '5', 'email' => 'clubintellect@mail.ru']
    )
    && $mydbobj->sql(
            $add_review,
            ['page_id' => '5', 'name' => 'Второй отзыв',
                'rev' => 'Пример отзыва',
                'autor' => 'Администратор сайта', 'vis' => '1', 'state' => 'good',
                'created' => $dt, 'rating' => '4', 'email' => 'clubintellect@mail.ru']
    )
    && $mydbobj->sql($adduser, ['login' => $admin_login, 'password' => $admin_password])
)
{
    echo "<div class='col-md-2'>OK</div></div>";
}
else
{
    die("<div class='col-md-2'>Ошибка при добавлении первоначальных данных</div></div>");
}

// удаляем установщик для предотвращения повторного добавления первоначальных данных
echo "<div class='row'>
    <div class='col-md-10'>Удаляем установщик</div>
    <div class='col-md-2'>OK</div>
</div>
<div class='jumbotron'>
    <div class='row'><div class='col-md-12'>Готово!</div></div>
    <div class='row'><div class='col-md-12'>
        <a href=\"$domain_name\">Перейти на сайт</a>&nbsp;|&nbsp; <a href=\"{$domain_name}\admin\">Система администрирования</a>
    </div>
</div>";
// !!!РАЗКОММЕНТИРУЙТЕ НА PRODUCTION!!!
// Удаляем файлы установщика:
unlink('app/classes/Login.php');
/*unlink('Установка.txt');
unlink('style/install.css');
unlink('install.php');*/
?>