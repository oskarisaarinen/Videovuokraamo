<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Syötä käyttäjätunnus.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Syötä salasana.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT myyjaID, kayttajatunnus, salasana FROM myyja WHERE kayttajatunnus = ?";
        
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
                        if($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Tarkista käyttätunnus ja salasana.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Tarkista käyttätunnus ja salasana.";
                }
            } else{
                echo "Oops! Kirjautuminen ei onnistunut. Yritä uudestaan.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

    include 'header.php';
?>
 
    <div class="container">
        <h2>Kirjaudu </h2>
        <p></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="col-sm-2 col-form-label">Käyttäjätunnus</label>
                <input type="text" name="username" class="col-sm-10" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="col-sm-2 col-form-label">Salasana</label>
                <input type="password" name="password" class="col-sm-10">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group row">
                <input type="submit" class="btn btn-primary" value="Kirjaudu">
            </div>

        </form>
    </div>    

<?php
    include 'footer.php';
?>