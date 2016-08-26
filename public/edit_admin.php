<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php 
    $admin = find_admin_by_id($_GET["id"]); 
    if (!$admin) {
        redirect_to("admin.php");
    }

?>

<?php 
    if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "old_password", "new_password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $admin["id"];
    $username = mysql_prep($_POST["username"]);
    $hashed_password = password_encrypt($_POST["new_password"]);
    
    if(!password_check($_POST["old_password"], $admin["hashed_password"])){
        $_SESSION["message"] = "Old password does not match current password.";
        redirect_to("edit_admin.php?id={$id}");
    }
  
    $query  = "UPDATE admins SET ";
    $query .= "username = '{$username}', ";
    $query .= "hashed_password = '{$hashed_password}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Admin updated.";
      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin update failed.";
    }
  
  } 
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <?php echo message(); ?>
            <?php echo form_errors($errors); ?>
                        
            <div class="form-group">
            <h2>Edit Admin</h2>
                <form action="edit_admin.php?id=<?php echo $admin["id"]; ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" value="<?php echo htmlentities($admin["username"]);?>" />
                    </div>
                    <div class="form-group">
                        <label for="password">Old Password:</label>
                        <input class="form-control" type="text" name="old_password" value="" />
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input class="form-control" type="text" name="new_password" value="" />
                    </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Edit Admin" />
                <a class="btn btn-danger pull-right" href="admin.php">Cancel</a>
                </form>
            </div>
      </div>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
