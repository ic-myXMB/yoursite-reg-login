<?php
// Check if the user is already logged in, if yes then
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){	?>
<h3>Logged in : <?php echo htmlspecialchars($_SESSION["username"]); ?> | <a class="btn btn-danger" href="logout.php" role="button">Log Out <i class="fa-solid fa-arrow-right-from-bracket"></i></a></h3>
<?php } else { ?>
<h3><a class="btn btn-primary" href="login.php" role="button">Login <i class="fa-solid fa-arrow-right-to-bracket"></i></a></h3>
<?php } ?>	