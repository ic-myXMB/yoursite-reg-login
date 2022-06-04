<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php
    // Define the page title
    $title = "Welcome, ".htmlspecialchars($_SESSION['username']).".";
    // Include the page header
    require_once("inc/header.php");
?>
<style>
    .wrapper{ width: 98%; margin: auto auto; padding: 20px; }
</style> 
<body>
  <div class="wrapper">  
    <h2><i class="fa-solid fa-user-check"></i> User</h2>
    <p>Member Introduction </p>    
    <div class="card">
        <h5 class="card-header"><i class="fa-solid fa-bullhorn"></i> Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h5>
        <div class="card-body">
            <div class="text-center">            
            <h1 class="my-5"> <i class="fa-solid fa-award fa-sm"></i> Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Thanks for visiting our site.</h1>
            </div>
            <div class="text-center">
            <a class="btn btn-warning m-1" href="reset-password.php" role="button">Reset Your Password <i class="fa-solid fa-rotate-right"></i></a>
            <a class="btn btn-danger m-1" href="logout.php" role="button">Sign Out Of Your Account <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </div>
    </div>
    <?php
     // Include the page footer
     require_once("inc/footer.php");
    ?>        
</body>
</html>