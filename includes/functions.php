<?php

function redirect_to($new_location) {
  header("Location: " . $new_location);
  exit;
}

function mysql_prep($string) {
    global $connection;

    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

function confirm_query($result_set) {
    if (!$result_set) {
            die("Database query failed.");
    }
}

function form_errors($errors=array()) {
  $output = "";
  if (!empty($errors)) {
    $output .= "<div class=\"error\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach ($errors as $key => $error) {
      $output .= "<li>";
      $output .= htmlentities($error);
      $output .= "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function text_cutoff($string, $length = 500){
    if (strlen($string) > $length) {

    // truncate string
    $stringCut = substr($string, 0, $length);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' '));
    $string .= "..."; 
}
return $string;
}

function find_selected_article(){
    global $connection;
    global $article;
    
    if(isset($_GET["blog"]) && isset($_GET["projects"])){
        return null;
    }elseif (isset($_GET["blog"])) {
        $article = find_article_by_id("blog", $_GET["blog"]);
    } elseif (isset($_GET["projects"])) {
        $article = find_article_by_id("projects", $_GET["projects"]);
    } else {
        return null;
    }
}

function find_subject_by_id($subject_id, $public=true) {
  global $connection;

  $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

  $query  = "SELECT * ";
  $query .= "FROM subjects ";
  $query .= "WHERE id = {$safe_subject_id} ";
  if ($public) {
    $query .= "AND visible = 1 ";
  }
  $query .= "LIMIT 1";
  $subject_set = mysqli_query($connection, $query);
  confirm_query($subject_set);
  if($subject = mysqli_fetch_assoc($subject_set)) {
    return $subject;
  } else {
    return null;
  }
}

function find_article_by_id($subject, $id, $public="false"){
  global $connection;

  $safe_id = mysqli_real_escape_string($connection, $id);
  $safe_subject = mysqli_real_escape_string($connection, $subject);

  $query  = "SELECT * ";
  $query .= "FROM $subject ";
  $query .= "WHERE id = {$safe_id} ";
  //$query .= "AND subject = {$safe_subject} ";
  if ($public) {
    $query .= "AND visible = 1 ";
  }
  $query .= "LIMIT 1";
  $article_set = mysqli_query($connection, $query);
  confirm_query($article_set);
  if($article = mysqli_fetch_assoc($article_set)) {
    return $article;
  } else {
    return null;
  }  
}

function find_all_articles($table, $order = "id", $limit = 3, $public = true) {
    global $connection;

    $query  = "SELECT * ";
    $query .= "FROM {$table} ";
    if($public){
        $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY {$order} DESC ";
    if($limit){
        $query .= "LIMIT {$limit}";
    }
    $article_set = mysqli_query($connection, $query);
    confirm_query($article_set);
    return $article_set;
}

function display_articles($table, $order="id", $limit=3, $public="true"){
    $output = "";
    $article_set = find_all_articles($table, $order);
    while($article = mysqli_fetch_assoc($article_set)){ 
        $output .= "<div class=\"panel panel-default\">";
            $output .= "<div class=\"panel-body\">";
                $output .= "<div class=\"page-header\">";
                    $output .= "<h3>";
                        $output .= $article["title"]; 
                    $output .= "<small class=\"pull-right date\">";
                    $output .= $article["date"];
                    $output .= "</small></h3>";
                $output .= "</div>";

                $output .=  image_path($article); 
                $output .= "<p>";
                $output .= $article["content"];
                $output .= "</p>";
            $output .= "</div>";
        $output .= "</div>";
        $output .= "<hr/>";
     } 
     return $output;
}

function image_path($article){
    $file_parts = pathinfo($article["image_path"]);

    switch($file_parts['extension'])
    {
        case "jpg":
        case "png":
            $img = "<img class=\"featureImage\" src=\"";
            $img .= $article["image_path"];
            $img .= "\" width=\"100%\"/>";
        break;

        case "mp4":
            $img = "<video width=\"100%\" height=\"auto\" controls=\"\">";
            $img .= "<source src=\"";
            $img .= $article["image_path"];
            $img .= "\" type=\"video/mp4\"/>";
            $img .= "Your browser does not support the video tag.";
            $img .= "</video>";
        break;

        default:
            $img = "";
        break;
    }
    return $img;
}

function navigation($table, $limit = 3){
    $output = "<div class=\"col-lg-3\">";
        $output .= "<div class=\"list-group\">";
            $output .= "<div class=\"sticky\" data-spy=\"affix\">";
                $article_set = find_all_articles($table, $limit);
                while($article = mysqli_fetch_assoc($article_set)){
                    $output .= "<a href=\"#";
                        $output .= $article["title"];
                    $output .=  "\" class=\"list-group-item\">";

                    $output .= "<h4 class=\"list-group-item-heading\">"; 
                        $output .= htmlentities($article["title"]); 
                    $output .= "</h4>";

                    $output .= "<p class=\"list-group-item-text\">";
                        $output .= nl2br(htmlentities($article["content"]));
                    $output .= "</p>";
                    $output .= "</a>";    
                }
                
            $output .= "</div>";
            $output .= "</div>";
    $output .= "</div>";
    return $output;
}

function dropdown_Edit($table){
    $post_set = find_all_articles($table, "id", null, false);
    $output  = "";
    while($post = mysqli_fetch_assoc($post_set)) {
        $output .= "<li>";
        $output .= "<a href=\"edit_post.php?{$table}=";
        $output .= urlencode($post["id"]);
        $output .= "\">";
        $output .= htmlentities($post["title"]);
        $output .= "</a>";
        $output .= "</li>";
    }
    $output .= "<li class=\"divider\"></li>";
    $output .= "<li><a href=\"#\">New Post</a></li";
    return $output;
}

function password_encrypt($password){
  $hash_format = "$2y$10$"; // 2y -> use blowfish encryption; 10 -> run the encryption 10 times;
  $salt_length = 22;
  $salt = generate_salt($salt_length); // Blowfish wants salts 22 chars, all others are ignored
  $format_and_salt = $hash_format . $salt;
  $hash = crypt($password, $format_and_salt);
  return $hash;
}

function generate_salt($length){
  $unique_rand_string = md5(uniqid(mt_rand(), true));

  // valid characters for salt are [a-zA-Z0-9./]
  $base64_string = base64_encode($unique_rand_string);

  $modified_base64_string = str_replace('+', '.', $base64_string);

  $salt = substr($modified_base64_string, 0, $length);

  return $salt;
}

function password_check($password, $existing_hash){
    $hash = crypt($password, $existing_hash);
    if($hash === $existing_hash){
        return true;
    } else{
        return false;
    }
}

function find_admin_by_username($username) {
  global $connection;

  $safe_username = mysqli_real_escape_string($connection, $username);

  $query  = "SELECT * ";
  $query .= "FROM admins ";
  $query .= "WHERE username = '{$safe_username}' ";
  $query .= "LIMIT 1";
  $admin_set = mysqli_query($connection, $query);
  confirm_query($admin_set);
  if($admin = mysqli_fetch_assoc($admin_set)) {
    return $admin;
  } else {
    return null;
  }
}

function attempt_login($username, $password){
    $admin = find_admin_by_username($username);
    if($admin){
        //found admin now check password
        if(password_check($password, $admin["hashed_password"])){
            return $admin;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function logged_in(){
    return isset($_SESSION["admin_id"]);
}

function confirm_logged_in(){
  if(!logged_in())
  {
      redirect_to("index.php");
  }
}

?>