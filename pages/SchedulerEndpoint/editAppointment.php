<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
$db = new DBContext();
if( isset($_POST["EdittedAppointmentTitle"]) && isset($_POST["EdittedAppointmentTime"])) {
    $id = $_POST["EdittedAppointmentID"];
    $title = $_POST["EdittedAppointmentTitle"];
    $time = str_replace("T"," ",$_POST["EdittedAppointmentTime"]);
    $location = null;
    $notes = null;
    if(isset($_POST["EdittedAppointmentLocation"])) $location =  $_POST["EdittedAppointmentLocation"];
    if(isset($_POST["EdittedAppointmentNotes"])) $notes = $_POST["EdittedAppointmentNotes"];

    $db->editAppointment(ltrim($id,'A'),$time,$location,$notes,$title);
}
header("Location: ..\\calenderView.php");
return;