<div class="container">
    <nav class="navbar navbar-light navbar-fixed-top" style="background-color: #7289da;">
        <form class="form-inline" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
            <?php if(isset($_SESSION["UserID"])):?><label style="float: left">Logged in as <?php echo $_SESSION["FirstName"]." ".$_SESSION["LastName"]?> UserID: <?php echo $_SESSION["UserID"]?></label><?php endif; ?>
            <a href="AppointmentsAndDeadlines.php" class="btn btn-outline-white" role="button">View Appointments and Deadlines</a>
            <?php if(isset($_SESSION["UserID"]))if(strpos($_SESSION["UserID"], "P") !== false):?><a href="addToFamilyPage.php" class="btn btn-outline-white" role="button">Add children to Family</a><?php endif; ?>
            <?php if(isset($_SESSION["UserID"])): ?> <input class="btn btn-outline-red" type="submit" name="logout" value="Log out">
            <?php else: ?> <a href="Login.php" class="btn btn-outline-green" role="button">Log in</a> <?php endif; ?>
        </form>
    </nav>
    <br>
</div>