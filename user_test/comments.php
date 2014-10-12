<!DOCTYPE HTML>
<html>
  <head>
    <title>TESTING COMMENT PAGE</title>
  </head>
  <body>

<?php
  // Include utility files
  require_once '../config.php';    
  require_once BUSINESS_DIR_COMMENT . 'CommentManager.php';

  $commentManager = new CommentManager();
  $comments = $commentManager->getAllComments();

  echo "<br/><br/><br/><b>See All Comments</b><br>";
  $commentCount = count($comments);            

  if($commentCount > 0){
    foreach($comments as $coms){    

      $id         =   $coms->getId();
      $text       =   $coms->getText();
      $rating_id  =   $coms->getRatingId();
      $created_by =   $coms->getCreatedBy();

  echo "The comment is: ".$text."<br>"; 

    } // end of foreach loop
  } // end of if statement
echo "<br/><br/><br/><b>************************</b><br>";

$commentManager = new CommentManager();
$commentsByUser = $commentManager->getCommentByUser("1");

$commentCount = count($commentsByUser);
if ($commentCount > 0){
  foreach($commentsByUser as $coms){
      $id         =   $coms->getId();
      $text       =   $coms->getText();
      $rating_id  =   $coms->getRatingId();
      $created_by =   $coms->getCreatedBy();

    echo "<br/><br/><b>Comments by user </b><br/>";
    echo "comment text: ". $text;    
  } //end of foreach loop
  echo "<br/><br/><br/><b>************************</b><br>";
} // end if 

?>
</body>
</html>
