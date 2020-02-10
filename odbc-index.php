<?php
include 'odbc-conn-02.php';
$sql = 'select * from "Players"';
$params = array();
$data = getData($sql, $params, true);

var_dump($data);
?>
