<?php

include_once "config.php";

$conn = new mysqli($server_bd, $user_bd, $password_bd, $name_bd);
$conn ->set_charset("utf8");
if ($conn->connect_error) die("Ошибка: невозможно подключиться: " . $conn->connect_error);

function generate_inf($from, $to){
    global $conn;
    $inf = array();

    $stmt = $conn->prepare("SELECT * FROM `sells` WHERE `dat` BETWEEN ? AND ?");
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $inf[$row['dat']] = $row['sum'];
    }

    return $inf;
}



?>