<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 26.09.2018
 * Time: 9:06
 */

include("../connect.php");

$name = $mysqli->real_escape_string($_POST['name']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$email = $mysqli->real_escape_string($_POST['email']);

$maxIDResult = $mysqli->query("SELECT MAX(id) FROM st_orders");
$maxID = $maxIDResult->fetch_array(MYSQLI_NUM);

$newID = $maxID[0] + 1;
$total = 0;

$basketResult = $mysqli->query("SELECT * FROM st_basket WHERE ip = '".real_ip()."'");
while($basket = $basketResult->fetch_assoc()) {
    $goodResult = $mysqli->query("SELECT * FROM st_shop WHERE id = '".$basket['good_id']."'");
    $good = $goodResult->fetch_assoc();

    $total += $basket['quantity'] * $good['price'];
}

if($mysqli->query("INSERT INTO st_orders (id, date, name, email, phone, price, accepted) VALUES ('".$newID."', '".date('Y-m-d H:i:s')."', '".$name."', '".$email."', '".$phone."', '".$total."', '0')")) {
    $basketResult = $mysqli->query("SELECT * FROM st_basket WHERE ip = '".real_ip()."'");
    while($basket = $basketResult->fetch_assoc()) {
        $mysqli->query("INSERT INTO st_orders_goods (order_id, good_id, quantity) VALUES ('".$newID."', '".$basket['good_id']."', '".$basket['quantity']."')");
    }

    $from = $name." <".$email.">";
    $to = CONTACT_EMAIL;
    $reply = $email;
    $subject = "New order №".$newID;
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
                        <b>Ссылка на заказ:</b> <a href='".$_SERVER['HTTP_HOST']."/admin/orders/?id=".$newID."'>".$_SERVER['HTTP_HOST']."/admin/orders/?id=".$newID."</a>
                        <br />
                        <b>Стоимость заказа:</b> ".$total."
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
        $mysqli->query("DELETE FROM st_basket WHERE ip = '".real_ip()."'");

        echo "ok";
    } else {
        echo "failed";
    }
}