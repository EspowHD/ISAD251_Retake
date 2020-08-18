<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
var_dump($_POST);
$db = new DBContext();
if( isset($_POST["NewDeadlineTitle"]) && isset($_POST["NewDeadlineTime"])) {
    $title = $_POST["NewDeadlineTitle"];
    $time = str_replace("T"," ",$_POST["NewDeadlineTime"]);
    $description = null;
    $completed = 0;
    if(isset($_POST["NewDeadlineDescription"]))$description = $_POST["NewDeadlineDescription"];
    if(isset($_POST["NewDeadlineCompleted"])){
        if($_POST["NewDeadlineCompleted"] == "on") $completed = 1;
    }

    $db->insertNewDeadline(ltrim($_SESSION["UserID"],'C'),$title,$time,$description,$completed);
}
header("Location: ..\\calenderView.php");
return;