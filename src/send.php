<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$phone = $_POST['phone'];
$massage = $_POST['massage'];
$email = $_POST['email'];
$emailSub = $_POST['emailSub'];
$nameFoot = $_POST['nameFoot'];

// Формирование самого письма
$title = "Новое сообщение Ehya";
$body = "
<h2>Новое сообщение</h2>
<b>Name: </b> $name<br>
<b>Phone: </b> $phone<br><br>
<b>Massage:</b><br>$massage<br><br>
<b>Email: </b> $email
";

$bodyMail = "
<h2>New subscription</h2>
<b>Email: </b> $emailSub
";

$bodyFoot = "
<h2>New massage</h2>
<b>Name: </b> $nameFoot<br>
<b>Phone: </b> $phone<br><br>
<b>Massage:</b><br>$massage<br><br>
";

$bodyFeedback = "
<h2>New massage feedback</h2>
<b>Name: </b> $nameFeedback<br>
<b>Phone: </b> $phone<br><br>
";



if(isset($_POST['emailSub'])){
    // если есть что-то в $_POST['emailSub']
    $body = $bodyMail;
} else {
    // если нет, отправлена форма с телефоном и пр.
    $body; 
}

if(isset($_POST['nameFoot'])){
    $body = $bodyFoot;
} else {
    // если нет, отправлена форма с телефоном и пр.
    $body; 
}

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'nikolayzholkin@gmail.com'; // Логин на почте
    $mail->Password   = 'blisytrgugkwvaed'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('ehya@19nikolas85.ru', 'Nikolay Zholkin'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('ehya@19nikolas85.ru');  

// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
header('location: thankyou.html');