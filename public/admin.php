<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $layout_context = "admin"; ?>
<?php $page = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <?php echo message(); ?>

        <h2>Admin Menu</h2>
        <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?></p>

        <hr/>

        <ul class="nav nav-pills">
          <li class="active"><a data-toggle="pill" href="#blog" class="btn-xl">Blog</a></li>
          <li><a data-toggle="pill" href="#projects" class="btn-xl">Project</a></li>
        </ul>

        <div class="tab-content">
          <div id="blog" class="tab-pane fade in active">
            <h3>Edit Blog</h3>
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Blog Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php
                    $post_set = find_all_articles("blog", "id", null, "DESC", false);
                    $output  = "";
                    while($post = mysqli_fetch_assoc($post_set)) {
                        $output .= "<li>";
                        $output .= "<a href=\"edit_post.php?blog=";
                        $output .= urlencode($post["id"]);
                        $output .= "\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    echo $output;
                ?>    
                </ul>
                <a href="new_post.php?blog" class="btn btn-warning new_post" role="button">New Post</a>
            </div>
          </div>
          <div id="projects" class="tab-pane fade">
            <h3>Edit Project</h3>
            <div class="btn-group">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Edit Project Post <span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php
                    $post_set = find_all_articles("projects", "id", null, "DESC", false);
                    $output  = "";
                    while($post = mysqli_fetch_assoc($post_set)) {
                        $output .= "<li>";
                        $output .= "<a href=\"edit_post.php?projects=";
                        $output .= urlencode($post["id"]);
                        $output .= "\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    echo $output;
                ?>    
                </ul>
                <a href="new_post.php?projects" class="btn btn-warning new_post" role="button">New Post</a>
            </div>          
          </div>
        </div>
        <hr/>
        <div class="form-group">
            <h3>Upload Image</h3>
            <form action="../includes/upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fileToUpload">Select image to upload:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <input class="btn btn-success" type="submit" value="Upload Image" name="submit">
            </form>
        </div>
        <hr/>
        <h3>Manage Admins</h3>
        
        <table>
          <tr>
              <th style="text-align: left; width: 200px;">Username</th>
              <th colspan="2" style="text-align: left; width: 100px;">Actions</th>
          </tr>

          <?php 
            $admin_set = find_all_admins();
            while($admins = mysqli_fetch_assoc($admin_set)){ ?>
              <tr>
                  <td><?php echo htmlentities($admins["username"]); ?></td>
                  <td><a href="edit_admin.php?id=<?php echo urlencode($admins["id"])?>">Edit</a></td>
                  
                  <td><a href="delete_admin.php?id=<?php echo urlencode($admins["id"])?>" 
                         onclick="return confirm('Are you sure?');">Delete</a></td>
              </tr>
          <?php } ?>
      </table>
        <br />
      <div class="btn-group">
            <a href="new_admin.php" class="btn btn-warning" role="button">New Admin</a>
      </div>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
