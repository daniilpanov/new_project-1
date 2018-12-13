<?php
namespace app\classes;

/**
 * @filename SendMail.php
 * набор компонентов для отправки письма
 * @author Любомир Пона & Даниил Панов
 * @copyright 24.09.2013
 * @updated 12.12.2018
 */

// класс подготовки и отправки email
class SendMail 
{
	private $to; // email получателя
    private $from; // email отправителя для ответа
    private $mail = "office@"; // email сервера с доменным именем
    private $phone; // номер телефона отправителя
    private $subject; // тема письма
    private $mess; // текст письма
    private	$headers; // заголовки
    private $files_size = 0; // реальный размер всех прикрепленных файлов
    private $max_mail_size = 10000000; //максимальный размер письма

    // метод подготовки email
    public function __construct($from, $subject, $mess, $phone = null, $file = null)
    {
        // кодируем тему письма
		$s = '=?utf-8?B?'.base64_encode($subject).'?=';

		// устанавливаем доменное имя и e-mail админа
        $this->to = $this->getAdminEmail();
        $this->mail .= $this->getServerEmail();

        // откуда пришло письмо
        $this->from = substr(htmlspecialchars(trim($from)), 0, 1000);
        // тема письма
		$this->subject = substr(htmlspecialchars(trim($s)), 0, 1000);

		// заголовок (от кого пришло письмо, кому отвечать, кодировка, тип и др.)
        $this->headers .= "From: " . $this->mail. "\r\n";
        $this->headers .= "Reply-To: " . $this->from . "\r\n";

        // если есть прикреплённые файл(ы)
        if ($file)
        {
            // создаём письмо с вложением
            $this->createWithAttach($mess, $phone, $file);
        }
        // иначе
        else
        {
            // создаём письмо
            $this->createWithoutAttach($mess, $phone);
        }
    }

    // создаём письмо с вложением
    private function createWithAttach($message, $phone, $files)
    {
        // задаем стандарт почтовых сообщений
        $this->headers = "MIME-Version: 1.0\r\n" . $this->headers;

        //  граница между фрагментами письма (прикрепленными файлами)
        $boundary = md5(date('r'));

        /* задаем тип содержания тела почтового сообщения
           смешанный документ(может состоять из фрагментов данных разного типа)/подтип "mixed"
        */
        $this->headers .= "Content-type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
        // сообщение (прямо в тексте указываем кодировку и др.)
        // ОБЯЗАТЕЛЬНО НАЧИНАТЬ С НАЧАЛА СТРОКИ БЕЗ ПРОБЕЛОВ И TAB!!!
        $message = "
Content-Type: multipart/mixed; boundary=\"{$boundary}\"

--{$boundary}
Content-Type: text/html; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

{$message}";

        // добавляем сам текст письма и дополнительные данные
        $this->addToMessage($message, $phone);

        // Перебираем элементы массива (foreach'ем не получится)
        for($i = 0; $i < count($files['name']); $i++)
        {
            // Если файл был загружен
            if (is_uploaded_file($files['tmp_name'][$i]))
            {
                // Подготавливаем сам файл
                $attachment = chunk_split(base64_encode(file_get_contents($files['tmp_name'])));
                // Имя файла
                $filename = $files['name'][$i];
                // Тип файла
                $filetype = $files['type'][$i];
                // Увеличиваем общий размер файлов
                $this->files_size += $files['size'][$i];

                $this->mess .= "
--{$boundary}
Content-Type: \"{$filetype}\"; name=\"{$filename}\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"{$filename}\"

{$attachment}";
            }
        }
        $this->mess .= "
--{$boundary}--";
        $this->mess = trim($this->mess);
    }

    // создаём письмо
    private function createWithoutAttach($message, $phone)
    {
        $this->headers .= "Content-type: text/html; charset=\"utf-8\"";
        // добавляем сам текст письма и дополнительные данные
        $this->addToMessage($message, $phone);
    }

    // добавляем текст письма и дополнительные данные
    private function addToMessage($mess, $phone = null)
    {
        $this->mess = substr(trim($mess), 0, 1000000);
        
        if($phone)
        {
            $this->phone = substr(htmlspecialchars(trim($phone)), 0, 1000);
            $this->mess .= "<br><br>Номер телефона для связи: ".$this->phone;
        }
        $this->mess .= "<br><br>Это письмо было отправлено с сайта ".$_SERVER['HTTP_HOST'];
    }

    // метод получения адреса почты администратора сайта
    private function getAdminEmail()
    {
        $sql = "SELECT admin_email FROM constants WHERE language = :language";
        $result = Db::getInstance()
            ->sql($sql, array("language" => $_SESSION['language']));

        $email = $result->fetch();
        return $email['admin_email'];
    }

    // метод получения почты сервера домена с которого отправляем почту
    private function getServerEmail()
    {
        $sql = "SELECT domainname FROM constants WHERE language = :language";
        $result = Db::getInstance()
            ->sql($sql, array("language" => $_SESSION['language']));

        $email = $result->fetch();
        $server_email = str_replace('http://','',$email['domainname']);
        $server_email = str_replace('/','.',$server_email);
        return $server_email;
    }

    // метод отправки email
    public function send($silent = null)
    {
        if ($this->files_size < $this->max_mail_size)
        {
            if(mail($this->to, $this->subject, $this->mess, $this->headers.'From:'.$this->mail))
            {
                if($silent != "silent")
                {
                    echo '<center><img src="admin/image/ok.png" border=0>'.SENT.'.</center>';
                }
            }
            else
            {
                if($silent != "silent")
                {
                    echo '<center><img src="admin/image/delete.png" border=0>Ошибка при отправке письма.</center>';
                }
            }
        }
        else
        {
            echo "Размер файлов слишком большой";
        }
    }
}