<div id="navigation-container">
	<div id="navigation">
		<a href = "index.php" title="Главная"><i class="icon-home icon-large"> </i></a>
		<a href = "?page=rumenulist" title="Список меню"><i class="icon-reorder icon-large"> </i></a>
		<a href = "?page=rulist" title="Список страниц"><i class="icon-list-ol icon-large"> </i></a>
        <a href = "?page=rureviews" title="Отзывы"><i class="icon-thumbs-up icon-large"> </i></a>
		<a href = "?page=languages" title="Языки"><i class="icon-globe icon-large"> </i></a>
		<a href = "?page=changeauth" title="Пользователи"><i class="icon-user icon-large"> </i></a>
		<a href = "?page=rusettings" title="Настройки"><i class="icon-cog icon-large"> </i></a>
		<a href = "?page=help" title="Помощь"><i class="icon-info-sign icon-large"> </i></a>
		<a href = "../index.php" title="На сайт" target="_blank"><i class="icon-reply icon-large"> </i></a>
		<a href = "exit.php" title="Выход"><?=$_SESSION['loged']." | Выйти"?></a>
	
        <div id="date">
            <?php
            echo \app\classes\Factory::getClassInst("GetDay", false);
            ?>
		</div><!--date-->
		
	</div><!--navigation-->
</div><!--navigation-container-->

<div id="content-container">
	<div id="content-container2">
		<div id="content-container3"><?php

		// создаем новые обьекты
        $vcreateedit = \app\classes\Factory::getClassInst("CcreateEdit"); // для работы со страницами
		$allmenus = \app\classes\Factory::getClassInst("Cmenu"); // для работы с меню
		$alllanguages = \app\classes\Factory::getClassInst("Clanguages"); // для работы с языками
		$settings = \app\classes\Factory::getClassInst("Csettings"); // для работы с настройками сайта
        $reviews = \app\classes\Factory::getClassInst("Creview"); // для работы с отзывами

        // Маршрутизатор
        // Если данные пришли с формы
        if($_POST)
        {
			// добавляем запись о новом меню в БД
        	if($_GET['menu'] == "rucreate" || $_GET['menu'] == "encreate")
        	{
                $allmenus->post_data($_POST);
            }
			
			// редактируем запись о существующем меню в БД
            elseif($_GET['menuedit']) 
        	{
                $allmenus->update_data($_POST);
            }	
			
			// удаляем список выделенных меню с БД
			elseif ($_POST['delmemenu']) 
        	{
				$del = $_POST['delmemenu'];
				
				foreach($del as $key =>$value)
				{
					$del_items[] = $value;
				}
                
				$menu = $allmenus->print_menuedit($del_items[0]);
				
				foreach($del as $key =>$value)
				{
					$allmenus->del_menu($value);
				}

				if($menu['language']=='ru')
				{
					require_once "views/vrumenulist.php" ;
				}
				elseif($menu['language']=='en')
				{
					require_once "views/venmenulist.php" ;
				}
				
            }
			
			
			// добавляем запись о новой странице в БД
        	elseif($_GET['page'] == "rucreate")
        	{
                $vcreateedit->post_data($_POST);
            }
			elseif($_GET['page'] == "encreate")
        	{
                $vcreateedit->post_data($_POST);
            }
			
			// редактируем запись о существующей странице в БД
            elseif ($_GET['edit']) 
        	{
                $vcreateedit->update_data($_POST);
            }
			
			// удаляем список выделенных страниц с БД
			elseif ($_POST['delme']) 
        	{
				$del = $_POST['delme'];
				
				foreach($del as $key =>$value)
				{
					$del_items[] = $value;
				}
                
				$page = $vcreateedit->print_pageedit($del_items[0]);
				
				foreach($del as $key =>$value)
				{
					$vcreateedit->del_page($value);
				}
											
				if($page['language']=='ru')
				{
					require_once "views/vrulist.php" ;
				}
				elseif($page['language']=='en')
				{
					require_once "views/venlist.php" ;
				}
				
            }

			
			// редактируем язык
			elseif($_GET['languageedit'])
			{
				$alllanguages->update_data($_POST);
			}
			
			// редактируем запись о пользователе системы администрирования в БД
			elseif($_GET['page'] == "changeauth")
			{
				require_once "views/vchangeauth.php" ;
			}
			
			// основные настройки сайта
			elseif($_GET['page'] == "rusettings")
			{
				$settings->update_data($_POST);
			}
			elseif($_GET['page'] == "ensettings")
			{
				$settings->update_data($_POST);
			}
			
			// если не выбрана страница для удаления
			elseif (!$_POST['delme']) 
        	{
				echo "<p align ='center'><img src='image/error.png' border=0> Вы не выбрали страницы для удаления.</p>";
            }										
		} 
		
		// если нажата кнопка, подключаем соответствующие виды
        if ($_GET)
        {
            // список меню
            if($_GET['page'] == "rumenulist")
            {
                require_once "views/vrumenulist.php" ;
            }
            elseif($_GET['page'] == "enmenulist")
            {
                require_once "views/venmenulist.php" ;
            }

            // создать меню
            elseif($_GET['menu'] == "rucreate")
            {
                require_once "views/vrumenucreate.php" ;
            }
            elseif($_GET['menu'] == "encreate")
            {
                require_once "views/venmenucreate.php" ;
            }

            // редактировать меню
            elseif($_GET['menuedit'])
            {
                require_once "views/vmenuedit.php" ;
            }

            // удалить меню
            elseif($_GET['menudelete'])
            {
                $id = $_GET['menudelete'];
                $menu = $allmenus->print_menuedit($id);

                $allmenus->del_menu($_GET['menudelete']);

                if($menu['language']=='ru')
                {
                    require_once "views/vrumenulist.php" ;
                }
                elseif($menu['language']=='en')
                {
                    require_once "views/venmenulist.php" ;
                }

            }

            // список страниц
            elseif($_GET['page'] == "rulist")
            {
                require_once "views/vrulist.php" ;
            }
            elseif($_GET['page'] == "enlist")
            {
                require_once "views/venlist.php" ;
            }

            // создать страницу
            elseif($_GET['page'] == "rucreate")
            {
                require_once "views/vrucreate.php" ;
            }
            elseif($_GET['page'] == "encreate")
            {
                require_once "views/vencreate.php" ;
            }

            // редактировать страницу
            elseif($_GET['edit'])
            {
                require_once "views/vedit.php" ;
            }

            // удалить страницу
            elseif($_GET['delete'])
            {
                $id = $_GET['delete'];
                $page = $vcreateedit->print_pageedit($id);

                $vcreateedit->del_page($_GET['delete']);

                if($page['language']=='ru')
                {
                    require_once "views/vrulist.php" ;
                }
                elseif($page['language']=='en')
                {
                    require_once "views/venlist.php" ;
                }
            }

            // список озывов
            elseif ($_GET['page'] == "rureviews")
            {
                require_once "views/vrureviews.php" ;
            }

            // список языков
            elseif($_GET['page'] == "languages")
            {
                require_once "views/vlanguages.php" ;
            }

            // редактировать язык
            elseif($_GET['languageedit'])
            {
                require_once "views/vlanguageedit.php" ;
            }

            // пользователи
            elseif($_GET['page'] == "changeauth")
            {
                require_once "views/vchangeauth.php" ;
            }

            // основные настройки сайта
            elseif($_GET['page'] == "rusettings")
            {
                require_once "views/vrusettings.php" ;
            }
            elseif($_GET['page'] == "ensettings")
            {
                require_once "views/vensettings.php" ;
            }
            // Uninstall
            elseif (isset($_GET['uninstall']))
            {
                header("Refresh: 0; URL=uninstall.php");
            }

            // помощь
            elseif($_GET['page']== "help")
            {
                require_once "views/vhelp.php" ;
            }
        }
        // выводим контент главной страницы панели администрирования
        else
        {
            $text=<<<HERE
                <p>Добро пожаловать в панель управления сайтом. Здесь Вы можете добавить, отредактировать или удалить информацию на сайте с помощью соответствующих пунктов верхнего меню пенели управления. Также можно изменить параметры входа в систему управления сайтом.</p>
HERE;
            echo $text;
        }
        ?>
		</div><!--content-container3-->
    </div><!--content-container2-->
</div><!--content-container-->
<div class="empty">&nbsp;</div><!--empty-->

</div><!--content-->