<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
$db = new DBContext();
if( isset($_POST["NewAppointmentTitle"]) && isset($_POST["NewAppointmentTime"])) {
     $title = $_POST["NewAppointmentTitle"];
     $time = str_replace("T"," ",$_POST["NewAppointmentTime"]);
     $location = null;
     $notes = null;
     if(isset($_POST["NewAppointmentLocation"])) $location =  $_POST["NewAppointmentLocation"];
     if(isset($_POST["NewAppointmentNotes"])) $notes = $_POST["NewAppointmentNotes"];

    $db->insertNewAppointment(ltrim($_SESSION["UserID"],'P'),$time,$location,$notes,$title);
}
header("Location: ..\\calenderView.php");
return;