<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
var_dump($_POST);
$db = new DBContext();
if( isset($_POST["EdittedDeadlineTitle"]) && isset($_POST["EdittedDeadlineTime"])) {
    $id = $_POST["EdittedDeadlineID"];
    $title = $_POST["EdittedDeadlineTitle"];
    $time = str_replace("T"," ",$_POST["EdittedDeadlineTime"]);
    $description = null;
    $completed = 0;
    if(isset($_POST["EdittedDeadlineDescription"]))$description = $_POST["EdittedDeadlineDescription"];
    if(isset($_POST["EdittedDeadlineCompleted"])){
        if($_POST["EdittedDeadlineCompleted"] == "on") $completed = 1;
    }

    $db->editDeadline(ltrim($id,'D'),$title,$time,$description,$completed);
}
header("Location: ..\\calenderView.php");
return;