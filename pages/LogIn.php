<?php
include_once "header.php";
if (isset($_SESSION["UserID"]))
{
    header("Location: AppointmentsAndDeadlines.php");
    die();
}
?>
<head>
    <title>Login page</title>
</head>
<link rel="stylesheet" href="CSS/FormPopup.css">
<link rel="stylesheet" href="CSS/RoundedButton.css">
<body>
<?php include "Page Parts/TopBar.php"; ?>
<br>
<h1 align="center" class ="title">Login Page</h1>
<br>
<form id="logInControls" class="form-inline" style="width:4000px; position: absolute; left: 50%; margin-left: -220px" >
    <button id="openLogin" class="button" onclick="return openLoginForm()" role="button">Login</button>
    <button id="openSignUp" class="button" onclick="return openSignUpForm()" role="button">SignUp</button>
</form>
<div class="form-popup" id="loginForm">
    <form class="form-container" method="POST" action="SchedulerEndpoint/loadLogin.php">
        <h1 class="title">Login</h1>

        <label for="LIId"><b>UserID</b></label>
        <input id="LIId" type="text" placeholder="Enter your UserID(e.g P9)" name="loginUserID" required>

        <input class="btn input" name="Submit" type="submit" value="Login">
    </form>
    <script>
        document.getElementById("loginForm").style.display = "block"
    </script>
</div>
<div class="form-popup" id="signUpForm">
    <form class="form-container" method="POST" action="">
        <h1 class="title">Sign up</h1>

        <label for="SUFname"><b>First Name</b></label>
        <input id="SUFname" type="text" placeholder="Enter your First Name" name="SignUpFname" required>

        <label for="SULname"><b>Last Name</b></label>
        <input id="SULname" type="text" placeholder="Enter your Last Name" name="SignUpLname" required>

        <label for="SUIsParent" style="display: inline-block"><b>Are you a parent?</b><input id="SUIsParent" style="display: inline-block" type="checkbox" name="SignUpIsParent"></label>



        <input class="btn input" name="Submit" type="submit" value="Sign up">
    </form>
</div>
</body>
<script>
    function openLoginForm(){
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("openLogin").disabled = true;
        document.getElementById("signUpForm").style.display = "none";
        document.getElementById("openSignUp").disabled = false;
        return false;
    }
    function openSignUpForm(){
        document.getElementById("signUpForm").style.display = "block"
        document.getElementById("openSignUp").disabled = true;
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("openLogin").disabled = false;
    return false;
    }
</script>