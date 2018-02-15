<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 15.02.2018
 * Time: 12:53
 */

include("connect.php");
include("recaptcha.php");

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$t = $mysqli->real_escape_string(nl2br($_POST['text']));

$secret = "6LfBT0MUAAAAAFpKcdVXwcljIzGXIEMZNVao7lL2";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if($_POST['g-recaptcha-response']) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER['REMOTE_ADDR'],
            $_POST['g-recaptcha-response']
        );
    }

    if($response != null && $response->success) {
        $goodResult = $mysqli->query("SELECT * FROM st_catalogue WHERE id = '".$_POST['id']."'");
        $good = $goodResult->fetch_assoc();

        $categoryResult = $mysqli->query("SELECT * FROM st_catalogue_categories WHERE id = '".$good['category_id']."'");
        $category = $categoryResult->fetch_assoc();

        $from = $name." <".$email.">";
        $to = CONTACT_EMAIL;
        $reply = $email;
        $subject = "Заказ товара: «".$good['name']."»";
        $text = "
            <div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px;'>
                <center>
                    <div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
                        <b>Имя:</b> ".$name."
                        <br />
                        <b>Email:</b> ".$email."
                        <br />
                        <b>Телефон:</b> ".$phone."
                        <br />
                        <b>Ссылка на товар:</b> <a href='".$_SERVER['HTTP_HOST']."/".$category['url']."/".$good['url']."'>".$_SERVER['HTTP_HOST']."/".$category['url']."/".$good['url']."</a>
                        <br /><br />
                        ".$t."
                    </div>
                    <br /><br />
                </center>
            </div>
        ";

        $hash = md5(rand(0, 10000000).date('Y-m-d H:i:s'));

        $headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
        $headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

        $message = "--PHP-mixed-".$hash."\n";
        $message .= "Content-Type: text/html; charset=\"utf-8\"\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $text."\n";
        $message .= "--PHP-mixed-".$hash."\n";

        if(mail($to, $subject, $message, $headers)) {
            echo "ok";
        } else {
            echo "failed";
        }
    } else {
        echo "captcha";
    }
} else {
    echo "email";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;