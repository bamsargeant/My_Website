<?php require_once("../includes/functions.php"); ?>
<?php
    if(!isset($layout_context)){
        $layout_context = "public";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
    <head>
        <title>WeaponOfChoice <?php if($layout_context == "admin") { echo "Admin"; }?></title>
        <?php if(!isset($page)){ $page = "";}?>
        <meta charset="utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">

        <link href = "css/bootstrap.min.css" rel = "stylesheet">
        <link href = "css/styles.css" rel = "stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <nav class = "navbar navbar-inverse navbar-top">
            <div class = "container-fluid my_header">
                <div class = "navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                    </button>

                    <a class = "navbar-brand" href = "index.php">Weapon of Choice</a>
                </div>

                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class = "nav navbar-nav">
                        <li <?php if($page == "index"){echo "class=\"active\"";} ?>> <a href = "index.php">Home</a> </li>
                        <li <?php if($page == "blog"){echo "class=\"active\"";} ?>> <a href = "blog.php">Blog</a> </li>
                        <li <?php if($page == "projects"){echo "class=\"active\"";} ?>> <a href = "projects.php">Projects</a> </li>
                        <li class="dropdown">
                            <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">Social Media <b class="caret"></b></a> 
                            <ul class="dropdown-menu">
                                <li> <a href="https://www.youtube.com/channel/UCTYsKt1mWQbQIS9VpZVZ3Tg" target="_blank">Youtube</a> </li>
                                <li> <a href="https://twitter.com" target="_blank">Twitter</a> </li>
                            </ul>
                        <li <?php if($page == "resume"){echo "class=\"active\"";} ?>> <a href = "resume.php">Resume</a> </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" >
                        <?php 
                        if(logged_in()){?>
                            <li <?php if($page == "admin"){echo "class=\"active\"";} ?>><a href = "admin.php">Admin</a></li>
                            <li><a href = "logout.php">Logout</a></li>
                        <?php } else { ?>
                            <li><a href = "login.php">Login</a></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </nav>