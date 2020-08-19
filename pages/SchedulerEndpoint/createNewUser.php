<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
var_dump($_POST);
$db = new DBContext();
if( isset($_POST["SignUpFname"]) && isset($_POST["SignUpLname"])) {
    if(isset($_POST["SignUpIsParent"])){
        if($_POST["SignUpIsParent"] == "on"){
            $db->insertNewParent($_POST["SignUpFname"],$_POST["SignUpLname"]);
            $data = $db->lastParentId();
            $userID = "P".$data["LastID"];
        }else {
            $db->insertNewChild($_POST["SignUpFname"],$_POST["SignUpLname"]);
            $data = $db->lastChildId();
            $userID = "C".$data["LastID"];
        }
    } else {
        $db->insertNewChild($_POST["SignUpFname"],$_POST["SignUpLname"]);
        $data = $db->lastChildId();
        $userID = "C".$data["LastID"];
    }
    $_SESSION["UserID"] = $userID;
    $_SESSION["FirstName"] = $_POST["SignUpFname"];
    $_SESSION["LastName"] =$_POST["SignUpLname"];
    header("Location: ..\\AppointmentsAndDeadlines.php");
    return;
} else {
    echo "<script> window.onload = function () {window.alert(\"No Parameters\")} </script>";
    header("Location: ..\\LogIn.php");
    return;
}