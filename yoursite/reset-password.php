<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config/config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the new password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<?php
    // Define the page title
    $title = "Reset Password";
    // Include the page header
    require_once("inc/header.php");
?> 
<style>
    .wrapper{ width: 98%; margin: auto auto; padding: 20px; }
</style>
<body>
  <div class="wrapper">
    <div class="float-end">
      <?php 
        // Include top menu
        include("inc/top_menu.php"); 
      ?>
    </div>     
    <h2><i class="fa-solid fa-file-pen"></i> Password Reset Form</h2>
    <p>Users can fill out this form to reset their passwords.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="card">
        <h5 class="card-header"><i class='fa-solid fa-redo-alt'></i> Reset Password</h5>
        <div class="card-body">
          <p class="card-text">Please fill out this form to reset your password.</p>
          <div class="form-floating mb-3">
            <input id="floatingNewPassword" placeholder="New Password" type="password" name="new_password" class="form-control 
            <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
            <label for="floatingNewPassword">New Password</label>
            <span class="invalid-feedback"> <?php echo $new_password_err; ?> </span>
          </div>
          <div class="form-floating mb-3">
            <input id="floatingConfirmNewPassword" placeholder="Confirm New Password" type="password" name="confirm_password" class="form-control 
                                <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <label for="floatingConfirmNewPassword">Confirm Password</label>
            <span class="invalid-feedback"> <?php echo $confirm_password_err; ?> </span>
          </div>
          <div class="form-outline mb-3">
          <button type="submit" class="btn btn-primary">Submit <i class="fa-solid fa-arrow-right"></i></button>
          <a class="btn btn-secondary" href="welcome.php" role="button">Cancel <i class="fa-solid fa-xmark"></i></a>
          </div>
    </form>
  </div>
  </div>
  </div>
  <?php
     // Include the page footer
     require_once("inc/footer.php");
    ?>         
</body>
</html>