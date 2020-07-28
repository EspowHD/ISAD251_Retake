<div class="container">
    <nav class="navbar navbar-light navbar-fixed-top" style="background-color: #7289DA;">
        <form class="form-inline" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
            <?php if(isset($_SESSION["UserID"])):?><label>Logged in as <?php echo $_SESSION["FirstName"],' ',$_SESSION["LastName"]?></label><?php endif; ?>
            <a href="calenderView.php" class="btn btn-outline-white" role="button">View Calender</a>
        </form>
    </nav>
    <br>
</div>