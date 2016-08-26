<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php logged_in(); ?>
<?php $layout_context = "public"; ?>
<?php $page = "projects"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <?php 
                if(!empty(display_articles($page))){
                    echo display_articles($page); 
                } else {
                    echo display_no_articles();
                }
            ?>
        </div>

        <?php echo navigation($page); ?>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>