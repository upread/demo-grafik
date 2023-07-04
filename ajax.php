<?php

if (!isset($_POST['reque'])){
    die();
}

include_once "utils.php";


if ($_POST['reque'] == "get_inf"){
    $from = $_POST['from'];
    $to = $_POST['to'];

    $arr["success"] = true;
    $arr["arr"] = generate_inf($from, $to);

    echo json_encode($arr);
}



?>