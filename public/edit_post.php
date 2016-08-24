<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>
<?php find_selected_article(); ?>

<?php
  if (!$article) {
    redirect_to("admin.php");
  }
?>

<?php /*
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $article["id"];
  $title = mysql_prep($_POST["title"]);
  $img_path = mysql_prep($_POST["img_path"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);
  $date = "CURDATE()";
  

  // validations
  $required_fields = array("title", "position", "visible", "content", "img_path");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("title" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Page updated.";
      redirect_to("manage_content.php?page={$id}");
    } else {
      // Failure
      $_SESSION["message"] = "Page update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
*/
?>

<?php $layout_context = "admin"; ?>
<?php $page = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <?php echo message(); ?>

        <h2>Edit Post</h2>
        <ul class="nav nav-pills">
          <li class="active"><a data-toggle="pill" href="#blog">Blog</a></li>
          <li><a data-toggle="pill" href="#projects">Project</a></li>
        </ul>

        <div class="tab-content">
          <div id="blog" class="tab-pane fade in active">
            <h3>Edit Blog</h3>
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Blog Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php echo dropdown_Edit("blog"); ?>    
                </ul>
            </div>
          </div>
          <div id="projects" class="tab-pane fade">
            <h3>Edit Project</h3>
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

        <form action="edit_post.php?id=<?php echo urlencode($article["id"]); ?>" method="post">
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
                    <input type="radio" name="optradio">Blog
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio">Projects
                </label>
                &emsp;
                <label class="checkbox-inline"><input type="checkbox" checked>Visible</label>

            </div>
            <div class="form-group">
                <label for="sel1">Position</label>
                <select class="form-control" id="sel1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Edit Post" />
            </div>
        </form>
        <hr/>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
