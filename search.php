<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
 
    <title>iDiscuss</title>
    <style>
    #maincontainer{
      min-height: 89vh;
    }
    </style>
  </head>
  <body>

      <?php include 'partials/dbconnect.php';?>
      <?php include 'partials/header.php';?>

<div class="container my-3" id="maincontainer">
    <h2>Search results for <em>"<?php echo $_GET['search'] ; ?>"</em></h2>

<?php
$noresult =true;
$query = $_GET["search"];
 $sql=  "select * from threads where match (thread_title, thread_desc) against ('$query')";
 $result = mysqli_query($data , $sql);
 $noresult = true;
 while($row = mysqli_fetch_assoc($result)){
   $noresult = false;
   $title = $row['thread_title'];
   $desc = $row['thread_desc'];
   $thread_id= $row['thread_id'];
   $url = "thread.php?threadid=".$thread_id ;
   $noresult =false;
   echo '<div class="result py-2">
   <h5> <a href="' .$url .'" class="text-dark">' .$title .'</a></h5>
   <p>'. $desc .'</p>
   </div>';
}
 if($noresult){
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-4">No results found</p>
      <p class="lead">Sorry we could not found results of <em>' .$_GET["search"] .' </em></p>
      <li>Make sure that all words are spelled correctly.</li>
      <li>Try different keywords.</li>
      <li>Try more general keywords.</li>
    </div>
  </div>';

   }
?>
</div>   
    <?php include 'partials/footer.php';  ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>