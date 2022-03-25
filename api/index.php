<?php
header('Content-type: text/html; charset=UTF-8');
use apiClass;
$API = new apiClass($_GET['class'],$_GET['method'], $_POST['params'], $_COOKIE['token']);
$API->callApiFunction();
echo json_encode($API->resultFunctionCall);
