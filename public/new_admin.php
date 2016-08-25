<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php //confirm_logged_in(); ?>

<?php 
    if(isset($_POST['submit'])){
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        
        $fields_with_max_lengths = array("username" => 30);
        validate_max_lengths($fields_with_max_lengths);
        
        if(empty($errors)){
            $username = mysql_prep($_POST["username"]);
            $hashed_password = password_encrypt($_POST["password"]);
            
            $query  = "INSERT INTO admins (";
            $query .= "username, hashed_password";
            $query .= ") VALUES (";
            $query .= " '{$username}', '{$hashed_password}'";
            $query .= ")";
            $result = mysqli_query($connection, $query);
            
            if($result){
                $_SESSION["message"] = "Admin Created";
                redirect_to("admin.php");
            } else {
                $_SESSION["message"] = "Admin creation failed: " . $query;
            }
        } else {

        }
    }
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <?php echo message(); ?>
            <?php echo form_errors($errors); ?>
            
            <div class="form-group">
            <h2>Create Admin</h2>
                <form action="new_admin.php" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" value="" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="text" name="password" value="" />
                    </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Create Admin" />
                <a class="btn btn-danger pull-right" href="admin.php">Cancel</a>
                </form>
            </div>
      </div>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
