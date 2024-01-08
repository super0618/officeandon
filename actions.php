<?php
require_once("db_config.php");
require_once("functions.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    unset($_POST['action']);
    $call = call_user_func($action, $_POST);
}