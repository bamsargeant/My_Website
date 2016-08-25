<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>
<?php find_selected_article(); ?>

<?php
  if (!$article) {
    redirect_to("admin.php");
  }
?>

<?php 
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $article["id"];
  $title = mysql_prep($_POST["title"]);
  $img_path = mysql_prep($_POST["img_path"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);
  $subject = $_POST["subject"];
  $date = "CURDATE()";
  

  // validations
  $required_fields = array("title", "position", "visible", "content", "img_path", "subject");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("title" => 30, "img_path" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE {$subject} SET ";
    $query .= "title = '{$title}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = 1, ";
    $query .= "content = '{$content}', ";
    $query .= "image_path = '{$img_path}' ";
    //$query .= "date = {$date} ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Page updated.";
      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Page update failed.";
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
        
        <?php 
            if(isset($_GET["blog"])){
                $main_title = "Edit Blog";
                $subject = "blog";
            } else if(isset($_GET["projects"])){
                $main_title = "Edit Project";
                $subject = "projects";

            } else {
                $main_title = "New Post";
                $subject = "";

            }
            
            echo "<h1>{$main_title}</h1>"
        ?>
        
        <hr/>

        <div class="tab-content">
          <div id="blog">
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Blog Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                    <?php echo dropdown_Edit("blog"); ?>    
                </ul>
            </div>
          </div>
            <br/>
            
          <div id="projects">
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Project Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                    <?php echo dropdown_Edit("projects"); ?>    
                </ul>
            </div>          
          </div>
        </div>
        
        <hr/>
        
        
    </div>
</div>

<div class="container">
    
       <div class="col-sm-10">
           <?php
                if(!isset($title))
                    $title = isset($article) ? $article["title"] : "";
                if(!isset($content))
                    $content = isset($article) ? $article["content"] : "";
                if(!isset($img_path))
                    $img_path = isset($article) ? $article["image_path"] : "";
            ?>

        <form action="edit_post.php?<?php echo urlencode($subject) . "=" . urlencode($article["id"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input class="form-control" id="title" name="title" value="<?php echo htmlentities($title); ?>" />
            </div>
            <div class="form-group">
                <label for="img_path">Image Path:</label>
                <input class="form-control" id="img_path" name="img_path" value="<?php echo htmlentities($img_path); ?>" />
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" name="content" id="content" rows="15" ><?php echo htmlentities($content);?></textarea>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="subject" value="blog" <?php if($subject == "blog") echo "checked"; ?>>Blog
                </label>
                <label class="radio-inline">
                    <input type="radio" name="subject" value="projects" <?php if($subject == "projects") echo "checked"; ?>>Projects
                </label>
                &emsp;
                <label class="checkbox-inline">Visible:
                    <input type="radio" name="visible" value="0" <?php if ($article["visible"] == 0) { echo "checked"; } ?> /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" <?php if ($article["visible"] == 1) { echo "checked"; } ?>/> Yes
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
                <input type="submit" name="submit" value="Edit Post" class="btn btn-success" role="button"/>
                <a href="edit_post.php?<?php echo urlencode($subject) . "=" . urlencode($article["id"]); ?>" class="btn btn-warning" role="button">Reset Form</a>
                <a href="admin.php" class="btn btn-danger pull-right" role="button">Cancel</a>
            </div>
        </form>
        <hr/>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
