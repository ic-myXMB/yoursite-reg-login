<?php

// Table is installing
function table_not_installed()
{

   // Table installing message
   $_SESSION['message4'] = '<div style="background-color:#46A7F5;color:#FFFFFF;opacity:0.83;transition:opacity 0.6s;margin-bottom:15px;padding:20px;border-radius:3px;">Table is not installed! So, installing.</div> ';

   if (isset($_SESSION['message4'])) {
   
     // Echo message
     echo $_SESSION['message4'];
   
     // Unset
     unset($_SESSION['message4']);

   }
}

// Table is already installed
function table_installed()
{

   // Table not installing message
   $_SESSION['message3'] = '<div style="background-color:#FFA92A;color:#FFFFFF;opacity:0.83;transition:opacity 0.6s;margin-bottom:15px;padding:20px;border-radius:3px;">Table was already installed! So, not installing.</div> ';

   if (isset($_SESSION['message3'])) {
   
     // Echo message
     echo $_SESSION['message3'];
   
     // Unset
     unset($_SESSION['message3']);

   }
}

// Database is already installed
function dbs_not_installed()
{

   // Database not installing message
   $_SESSION['message2'] = '<div style="background-color:#F56257;color:#FFFFFF;opacity:0.83;transition:opacity 0.6s;margin-bottom:15px;padding:20px;border-radius:3px;">Database was already installed! You can begin by creating an account. <a href="register.php" style="color:#FFFFFF;">Sign up now</a></div> ';

   if (isset($_SESSION['message2'])) {
   
     // Echo message
     echo $_SESSION['message2'];
   
     // Unset
     unset($_SESSION['message2']);

   }
}

// Database is installing
function dbs_installed()
{

   // Database is installed message
   $_SESSION['message1'] = '<div style="background-color:#04AA6D;color:#FFFFFF;opacity:0.83;transition:opacity 0.6s;margin-bottom:15px;padding:20px;border-radius:3px;">Database is installed! You can begin by creating an account. <a href="register.php" style="color:#FFFFFF;">Sign up now</a></div> ';

   if (isset($_SESSION['message1'])) {
   
     // Echo message
     echo $_SESSION['message1'];
   
     // Unset
     unset($_SESSION['message1']);

   }
}

// Install database
function install_dbs(){

 // Include the config file
 require_once "config/config.php";

 // Get the config details
 $mysqli =$link;
 $result = $link;

 // Empty
 $users = '';

  // Check for users table
    if ($result = $mysqli->query("SHOW TABLES LIKE '".$users."'")){
    
       // If table exists
       if($result->num_rows == 1) {
        
         // Echo exists message
         table_installed();
        
         // Echo exists message
         dbs_not_installed();

        }

       // If table does not exist
       if($result->num_rows == null){
        
         // Echo does not exist message
         table_not_installed(); 
        
         // Get the database sql file
         $sql = file_get_contents('dbs/users.sql');
        
         // Execute multi query
         $mysqli->multi_query($sql);
        
         // Echo database installing message
         dbs_installed();

        }    
    }
}
?>
<?php
    // Define the page title
    $title = "Install Database";
    // Include the page header
    require_once("inc/header.php");
?>
<style>
    .wrapper{ width: 98%; margin: auto auto; padding: 20px; }
</style>
<body>
    <div class="wrapper">
        <?php // add switch
        include("inc/switch.php");
        ?>      
        <h2><i class="fa-solid fa-database"></i> Installation</h2>
        <p>Details about the database install process.</p> 
        <div class="card bg-light">
          <h5 class="card-header"><i class="fa-solid fa-screwdriver-wrench"></i> Database</h5>
          <div class="card-body">
            <p class="card-text">Information...</p> 

              <?php 
                 // Install database
                 install_dbs(); 
                ?>

           </div>
       </div>
   </div>
   <?php
     // Include the page footer
     require_once("inc/footer.php");
    ?>
</body>
</html>