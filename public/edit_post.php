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
  $menu_name = mysql_prep($_POST["menu_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);

  // validations
  $required_fields = array("menu_name", "position", "visible", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("menu_name" => 30);
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
                <?php
                    $post_set = find_all_articles("blog", "id", null, false);
                    $output  = "";
                    while($post = mysqli_fetch_assoc($post_set)) {
                        $output .= "<li>";
                        $output .= "<a href=\"edit_post.php?subject=";
                        $output .= urlencode($post["id"]);
                        $output .= "#blog\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    echo $output;
                ?>    
                </ul>
            </div>
          </div>
          <div id="projects" class="tab-pane fade">
            <h3>Edit Project</h3>
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Project Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php
                    $post_set = find_all_articles("projects", "id", null, false);
                    $output  = "";
                    while($post = mysqli_fetch_assoc($post_set)) {
                        $output .= "<li>";
                        $output .= "<a href=\"edit_post.php?subject=";
                        $output .= urlencode($post["id"]);
                        $output .= "#projects\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    echo $output;
                ?>    
                </ul>
            </div>          
          </div>
        </div>
        <hr/>
        
    </div>
</div>

<div class="container">
    <div class="form-group">
       <div class="col-sm-10">
            <form action="edit_post.php?id=<?php echo urlencode($article["id"]); ?>" method="post">
                <h4>Title:</h4>
                <input type="text" id="title" name="title" value="" />
                <br/>
                <h4>Content:</h4>
                <textarea name="content" id="content" rows="20" cols="80"></textarea>
                <br/>
                <br/>
                <input type="submit" name="submit" value="Edit Post" />
            </form>
        </div>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
