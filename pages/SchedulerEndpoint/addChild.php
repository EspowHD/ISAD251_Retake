<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
$db = new DBContext();
if( isset($_POST["ChildID"])) {
    if(strpos($_POST["ChildID"],"C") !== false) {
        $db->insertParentToChild(ltrim($_SESSION["UserID"],"P"),ltrim($_POST["ChildID"],"C"));
    } else echo "<script> window.onload = function () {window.alert(\"You cannot add a parent as a child\")} </script>";
}
else
{
    echo "<script> window.onload = function () {window.alert(\"No Parameters\")} </script>";
}
header("Location: ..\\addToFamilyPage.php");
return;