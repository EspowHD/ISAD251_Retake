<?php
include_once "..\\..\\Classes\\DBContext.php";
if(isset($_POST["id"]))
{
    $ID = substr($_POST["id"], 1);
    $db = new DBContext();
    if ($_POST["id"][0] == "A")
    {
        $db->DeleteAppointment($ID);
        http_response_code(200);
    }
    elseif ($_POST["id"][0] == "D")
    {
        $db->DeleteDeadline($ID);
        http_response_code(200);
    }
}
else
{
    echo "No parameters";
}
?>
