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
                        $output .= "<a href=\"edit_post.php?blog=";
                        $output .= urlencode($post["id"]);
                        $output .= "\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    $output .= "<li class=\"divider\"></li>";
                    $output .= "<li><a href=\"#\">New Post</a></li";
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
                        $output .= "<a href=\"edit_post.php?projects=";
                        $output .= urlencode($post["id"]);
                        $output .= "\">";
                        $output .= htmlentities($post["title"]);
                        $output .= "</a>";
                        $output .= "</li>";
                    }
                    $output .= "<li class=\"divider\"></li>";
                    $output .= "<li><a href=\"#\">New Post</a></li";
                    echo $output;
                ?>    
                </ul>
            </div>          
          </div>
        </div>
        <hr/>
       
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
