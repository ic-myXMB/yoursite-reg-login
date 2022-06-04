<?php
// Include the config file
require_once "config/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result 
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    $title = "Sign Up";
    // Include the page header
    require_once("inc/header.php");
?>
<style>
    .wrapper{ width: 98%; margin: auto auto; padding: 20px; }
</style>
<body>
  <div class="wrapper">
    <h2><i class="fa-solid fa-file-pen"></i> Registration Form</h2>
    <p>Users can fill out this form to register an account.</p>
    <form action="
            <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="card">
        <h5 class="card-header"><i class="fa-solid fa-user-plus"></i> Sign Up</h5>
        <div class="card-body">
          <p class="card-text">Please fill in this form to create an account.</p>
          <div class="form-floating mb-3">
            <input id="floatingUsername" placeholder="Username" type="username" name="username" class="form-control 
            <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <label for="floatingUsername">Username</label>
            <span class="invalid-feedback"> <?php echo $username_err; ?> </span>
          </div>
          <div class="form-floating mb-3">
            <input id="floatingPassword" placeholder="Password" type="password" name="password" class="form-control 
            <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <label for="floatingPassword">Password</label>
            <span class="invalid-feedback"> <?php echo $password_err; ?> </span>
          </div>
          <div class="form-floating mb-3">
            <input id="floatingConfirmPassword" placeholder="Confirm Password" type="password" name="confirm_password" class="form-control 
            <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <label for="floatingConfirmPassword">Confirm Password</label>
            <span class="invalid-feedback"> <?php echo $confirm_password_err; ?> </span>
          </div>
          <div class="form-outline mb-3">
            <button type="submit" class="btn btn-primary">Submit <i class="fa-solid fa-arrow-right"></i></button>
            <button type="reset" class="btn btn-secondary">Reset <i class='fa-solid fa-redo-alt'></i></button>
          </div>
          <div class="text-center">
            <p>Already have an account? <a href="login.php">Login here</a>. </p>
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