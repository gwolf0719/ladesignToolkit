<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../vendor/autoload.php';
class Send
{
    function email($subject, $email, $body)
    {
        $mail = new PHPMailer(true);                    // Passing `true` enables exceptions
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->CharSet = "utf-8";                       //信件編碼
        $mail->Username = "sugarmeetingtw@gmail.com";   //帳號，例:example@gmail.com
        $mail->Password = "mtfuthnotgsbqoqo";           //密碼
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug  = 0;
        $mail->Encoding = "base64";
        $mail->IsHTML(true);                            //內容HTML格式
        $mail->From = "sugarmeetingtw@gmail.com";       //寄件者信箱
        $mail->FromName = "sugarmeetingtw";             //寄信者姓名
        $mail->Subject = $subject;              //信件主旨
        $mail->Body = $body;                       //信件內容
        $mail->AddAddress($email);     //收件者信箱
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    }



    function sendSMS($mobile, $text)
    {
        $username = '90863941SMS';
        $password = 'arktsai12345';
        $text = urlencode($text);
        $api = 'https://smsapi.mitake.com.tw/api/mtk/SmSend?username=' . $username . '&password=' . $password . '&dstaddr=' . $mobile . '&smbody=' . $text . '&%27CharsetURL=UTF-8';
        $http_build_query = array(
            'username' => $username,
            'password' => $password,
            'dstaddr' => $mobile,
            'smbody' => $text,
            'CharsetURL' => 'UTF-8'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($http_build_query));
        $output = curl_exec($ch);
        curl_close($ch);
    }
}
