<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 
    $username = "";
    if(isset($_POST['submit'])){
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        
        if(empty($errors)){
            // Attempt login
            $username = $_POST["username"];
            $password = $_POST["password"];
            $found_admin = attempt_login($username, $password);
            
            if($found_admin){
                // Mark user as logged in
                $_SESSION["admin_id"] = $found_admin["id"];
                $_SESSION["username"] = $found_admin["username"];
                redirect_to("admin.php");
            } else {
                $_SESSION["message"] = "Username/Password not found.";
            }
        } else {

        }
    }
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>

    <h2>Login</h2>
    <form action="login.php" method="post" class="form-horizontal">
    <div class="form-group">
       <label class="control-label col-sm-2" for="username">Username:</label>
       <div class="col-sm-10">
           <input type="text" id="username" name="username" value="<?php echo htmlentities($username); ?>" />
       </div>
    </div>
        
    <div class="form-group">
       <label class="control-label col-sm-2" for="password">Password:</label>
       <div class="col-sm-10">
           <input type="password" id="password" name="password" value="" />
           
            <div class="col-sm-offset-2 col-sm-10">
                <br/>
                <button type="submit" name="submit" class="btn btn-default">Submit</button>
            </div>
       </div>
 
    </form>
    </div>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
