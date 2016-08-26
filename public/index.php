<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php $layout_context = "public"; ?>
<?php $page = "index"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="jumbotron">
        <h1>Weapon of Choice</h1>
        <p>Brett Sargeant's DevBlog</p>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-sm-6 col-md-8 section-heading">
                    <h1>About Me</h1>
                    <hr/>
                    <p>Hi! I'm Brett Sargeant.</p>
                    <p>I'm a junior programmer for both video games and websites. I first started with C++ in 2012 at Hornsby Tafe studying for a diploma of video games, 
                        and followed through to finishing a Bachelor of IT in Games Design and Development, where I learn Unity, OpenGL, Java and Object Oriented Programming, ProLog, Python and MySQL.</p>
                    <p>I have also self taught myself HTML and PHP, and I am learning Javascript at the moment.</p>
                    <p>I am aspiring to be a go-to programmer, someone who knows the language back to front and can help others learn too.</p>
                    <hr/>
                    <a href="resume.php" class="btn btn-default">Read More in my resume</a>

                </div>	
            </div>	
        </div>								
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    $article_set = find_all_articles("blog");
                    if($article = mysqli_fetch_assoc($article_set)){ 
                ?>
                <div class="col-sm-6 col-md-8 section-heading">

                    <div class="page-header">
                            <h3><a href="blog.php">Latest Blog</a> <small class="pull-right date"><?php echo $article["date"]; ?></small></h3>
                    </div>
                    <p><?php echo text_cutoff($article["content"], 500); ?></p>
                    <a href="blog.php" class="btn btn-default">Read More</a>
                </div>

                <div class="col-sm-6 col-md-4 hidden-xs section-details thumbCol">
                    <?php echo image_path($article); ?>
                </div>
                <?php }  else {
                    echo display_no_articles();
                }?>
            </div>	
        </div>								
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    $article_set = find_all_articles("projects");
                    if($article = mysqli_fetch_assoc($article_set)){ 
                ?>
                <div class="col-sm-6 col-md-8 section-heading">
                    <div class="page-header">
                        <h3><a href="projects.php">Latest Project</a> <small class="pull-right date"><?php echo $article["date"]; ?></small></h3>
                    </div>
                    <p><?php echo text_cutoff($article["content"]); ?></p>
                    <a href="projects.php" class="btn btn-default">Read More</a>
                </div>

                <div class="col-sm-6 col-md-4 hidden-xs section-details thumbCol">
                    <?php echo image_path($article); ?>
                </div>
                <?php }  else {
                    echo display_no_articles();
                }?>
            </div>	
        </div>								
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
