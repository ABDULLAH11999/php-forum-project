<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
  #ques{
    min-height: 433px;
  }
</style>
    <title>iDiscuss</title>
  </head>
  <body>

  <?php include 'partials/header.php';?>
  <?php include 'partials/dbconnect.php';?>
  <?php
  $id = $_GET['threadid'];
  $sql=  "SELECT * FROM `threads` WHERE thread_id=$id";
  $result = mysqli_query($data , $sql);
  $noresult = true;
  while($row = mysqli_fetch_assoc($result)){
    $noresult = false;
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_user_id = $row['thread_user_id'];
    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
    $result2 = mysqli_query($data, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $posted_by = $row2['user_email'];
    }
      
  ?>
  <?php
 $showalert = false;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
  $comment = $_POST['comment'];
  $comment = str_replace("<", "&lt;", $comment);
  $comment = str_replace(">", "&gt;", $comment); 
  $sno = $_POST['sno']; 
  $sql=  "INSERT INTO `comments` (`comment_content`,`thread_id`,`comment_by`,`comment_time`) VALUES ('$comment','$id','$sno',CURRENT_TIME())";
  $result = mysqli_query($data , $sql);
  $showalert = true;
  if($showalert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>SUCCESS! </strong> Your comment has been added!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div> ';
  }

}

?>

<div class="container my-4"  >
<div class="jumbotron">
  <h1 class="display-4"><?php echo $title ?></h1>
  <p class="lead"><?php echo $desc ?></p>
  <hr class="my-4">
  <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums. ...
Do not post copyright-infringing material. ...
Do not post “offensive” posts, links or images. ...
Do not cross post questions. ...
Do not PM users asking for help. ...
Remain respectful of other members at all times.
  </p>
<p>Posted by: <b><?php echo $posted_by; ?></p>
</div>
</div>

<?php 
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){ 
 echo '    
<div class="container" id="ques">
  <h2 class="py-2">Post a comment</h2>
<form action= "'.$_SERVER['REQUEST_URI'].'"  method="post" >

  <div class="form-group">
    <label for="exampleFormControlTextarea1">Type your Comment</label>
    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
    <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
    </div>

  <button type="submit" class="btn btn-success">Post Comment</button>
</form>
</div>';
  }
  else{
    echo '
    <div class="container">
    <h1 class="py-2">Post a comment</h1> 
       <p class="lead">You are not logged in. Please login to be able to post a comment</p>
    </div>
    ';
  }
?>


<div class="container" id="ques">
    <h2 class="py-2">Discussions</h2>
    <?php
  $id = $_GET['threadid'];
  $sql=  "SELECT * FROM `comments` WHERE thread_id=$id";
  $result = mysqli_query($data , $sql);
  $noresult = true;
  while($row = mysqli_fetch_assoc($result)){
    $noresult = false;
    $id = $row['comment_id'];
    $content = $row['comment_content'];
    $comment_time = $row['comment_time'];
    $thread_user_id = $row['comment_by']; 
    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
    $result2 = mysqli_query($data, $sql2);
    $row2 = mysqli_fetch_assoc($result2);


    echo '  <div class="media my-3">
            <img src="img/users.png" width="54px" class="mr-3" alt="">
            <div class="media-body">
            <p class="font-weight-bold my-0">'. $row2['user_email'] . ' commented at /' .$comment_time . '</p> 
                ' . $content . ' 
        </div>
        </div> ';
  }
  if($noresult){
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-4">No comments found</p>
      <p class="lead">Be the first person to comment</p>
    </div>
  </div>';
  }
    ?> 
</div>
</div>
    <?php include 'partials/footer.php';  ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>