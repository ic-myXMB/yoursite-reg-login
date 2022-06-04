<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect them to the welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include the config file
require_once "config/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
    $title = "Login";
    // Include the page header
    require_once("inc/header.php");
?>
<style>
    .wrapper{ width: 98%; margin: auto auto; padding: 20px; }
</style>
<body>
    <div class="wrapper">
        <h2><i class="fa-solid fa-file-pen"></i> User Login Form</h2>
        <p>Users can fill in their credentials to login here.</p>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <div class="card">
          <h5 class="card-header"><i class="fa-solid fa-key"></i> Login</h5>
          <div class="card-body">
            <p class="card-text">Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-floating mb-3">
                <input id="floatingUsername" placeholder="Username" type="username" name="username" class="form-control 
                    <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" />
                <label for="floatingUsername">Username</label>
                <span class="invalid-feedback"> <?php echo $username_err; ?> </span>
              </div>
              <div class="form-floating mb-3">
                <input id="floatingPassword" placeholder="Password" type="password" name="password" class="form-control 
                        <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <label for="floatingPassword">Password</label>
                <span class="invalid-feedback"> <?php echo $password_err; ?> </span>
              </div>
              <div class="form-outline mb-3">
                <button type="submit" class="btn btn-primary">Sign in <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
              </div>
              <div class="text-center">
                <p>Don't have an account? <a href="register.php">Sign up now</a>. </p>
              </div>
            </form>
          </div>
        </div>
        </div>
        <?php 
          // Include the page foter
          require_once("inc/footer.php"); 
        ?> 
</body>
</html>