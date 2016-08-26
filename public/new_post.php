<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php 
if (isset($_POST['submit'])) {
  // Process the form
  
  $title = mysql_prep($_POST["title"]);
  $img_path = mysql_prep($_POST["img_path"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep(nl2br($_POST["content"]));
  $subject = mysql_prep($_POST["subject"]);
  $date = "CURDATE()";

  // validations
  $required_fields = array("title", "position", "visible", "content", "img_path", "subject");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("title" => 30, "img_path" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "INSERT INTO {$subject} (";
    $query .= "  title, image_path, position, visible, content, date";
    $query .= ") VALUES (";
    $query .= "  '{$title}', '{$img_path}', {$position}, {$visible}, '{$content}', $date";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Page created.";
      redirect_to("{$subject}.php");
    } else {
      // Failure
      $_SESSION["message"] = "Page creation failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "admin"; ?>
<?php $page = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <?php echo message(); ?>
        <?php echo form_errors($errors); ?>        
        <?php
            if(isset($_GET["blog"])){
                $main_title = "New Blog";
                $subject = "blog";
            } else if(isset($_GET["projects"])){
                $main_title = "New Project";
                $subject = "projects";

            } else {
                $main_title = "New Post";
                $subject = "";

            }
            
            echo "<h1>{$main_title}</h1>";
        ?>
        <hr/>
        
    </div>
</div>

<div class="container">
    
       <div class="col-sm-10">

        <form action="new_post.php" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input class="form-control" id="title" name="title" value="" />
            </div>
            <div class="form-group">
                <?php echo dropdown_images();?>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" name="content" id="content" rows="15" ></textarea>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="subject" value="blog" <?php if($subject != "projects") echo "checked"; ?>>Blog
                </label>
                <label class="radio-inline">
                    <input type="radio" name="subject" value="projects" <?php if($subject == "projects") echo "checked"; ?>>Projects
                </label>
                &emsp;
                <label class="checkbox-inline">Visible:
                    <input type="radio" name="visible" value="0"/> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" checked/> Yes
                </label>

            </div>
            <div class="form-group">
                <label for="sel1">Position</label>
                <select class="form-control" id="sel1" name="position">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Create Post" class="btn btn-success" role="button"/>
                <a href="new_post.php" class="btn btn-warning" role="button">Reset Form</a>
                <a href="admin.php" class="btn btn-danger pull-right" role="button">Cancel</a>
            </div>
        </form>
        <hr/>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
