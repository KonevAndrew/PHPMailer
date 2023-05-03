<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.8.0/src/Exception.php';
require 'PHPMailer-6.8.0/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru','PHPMailer-6.8.0/language/');
$mail->IsHTML(true);

//от кого письмо
$mail->setFrom('andrey_konev@internet.ru','Конев Андрей');
//кому отправить
$mail->addAddress('a9139286138@yandex.ru');
//тема письма
$mail->Subject = 'Привет это Андрей Конев';
//рука
$hand ="правая";
if($_POST['hand'] ==" left"){
    $hand = "левая";
}

//тело письма
$body = '<h1>Письмо с сайта</h1>';

if(trim(!empty($_POST['name']))) {
    $body.='<p><strong>Имя: </strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))) {
    $body.='<p><strong>E-mail: </strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))) {
    $body.='<p><strong>Рука: </strong> '.$hand.'</p>';

}if(trim(!empty($_POST['age']))) {
    $body.='<p><strong>Возраст: </strong> '.$_POST['age'].'</p>';

}if(trim(!empty($_POST['message']))) {
    $body.='<p><strong>Сообщение: </strong> '.$_POST['message'].'</p>';
}
//прикрепить файл
if (!empty($_FILES['image']['tmp_name'])) {
    //путь зарузки файла
    $filePath = __DIR__ . '/files/' . $_FILES['image']['name'];
    //грузим файл
    if (copy($_FILES['image']['tmp_name'], $filePath)) {
        $fileAttach = $filePath;
        $body.='<p><strong>Фото в приложении</strong>';
        $mail->addAttachment($fileAttach);
    }
}   

$mail->Body = $body;

//отправляем
if (!$mail->send()) {
        $message = 'Ошибка';
    } else { 
        $message = 'Данные отправлены';
    }
    $response = ['message' => $message];
    header('Content-type: application/json');
    echo json_encode($response);
    
?>
