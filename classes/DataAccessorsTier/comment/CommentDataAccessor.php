<?PHP
  
  require_once DB_CONNECTION . 'DBHelper.php';
  require_once BUSINESS_DIR_COMMENT . 'Comment.php';
  require_once DB_CONNECTION . 'datainfo.php';

  class CommentDataAccessor {

    public function addComment($comment) {

      //$id = $comment->getId();
      $text = $comment->getText();
      $rating_id = $comment->getRatingId();
      $created_by = $comment->getCreatedBy();
      $entry_id = $comment->getEntryId();
        
      $rating_id = isset($rating_id) ? $rating_id : "";
      //printf ("CommentDataAccess text: ". $text."<br/>");
      //printf ("CommentDataAccess rating_id: ". $rating_id."<br/>");  
      //printf ("CommentDataAccess created_by: ". $created_by."<br/>");
      //printf ("CommentDataAccess entry_id: ". $entry_id."<br/>");

      if($rating_id != "" ) {
        $query_insert="INSERT INTO ".COMMENT." (com_text, com_rating_id, com_created_by, com_entry_id, com_created_on) 
                        VALUES ('".$text."', ".$rating_id.", ".$created_by.", '".$entry_id."', NOW())";
      } else {
        $query_insert="INSERT INTO ".COMMENT." (com_text, com_created_by, com_entry_id, com_created_on) 
                        VALUES ('".$text."', ".$created_by.", '".$entry_id."', NOW())";
      }

      $dbHelper = new DBHelper();
      $last_inserted_id = $dbHelper->executeInsertQuery($query_insert);
      //printf ("CommentDataAccess mysqli_insert_id: ". $last_inserted_id);
      
      return $last_inserted_id;

    }

    public function updateComment($comment) {
      $id = $comment->getId();
      $text = $comment->getText();
      $rating_id = $comment->getRatingId();
//      $created_by = $comment->getCreatedBy();
//      $entry_id = $comment->getEntryId();
      $rating_id = isset($rating_id) ? $rating_id : "";
      $curr_datetime  = date('Y-m-d H:i:s');
      if($rating_id != "" ) {
          $query_update = "UPDATE ".COMMENT." SET 
            com_text = '".$text.
            "', com_rating_id = '".$rating_id.
            "', com_created_on = '".$curr_datetime.
              
    //      "', com_created_by = '".$created_by.
    //      "', com_entry_id = '".$entry_id.
            "' WHERE com_comment_id = '".$id."'";
      } else {
          $query_update = "UPDATE ".COMMENT." SET 
            com_text = '".$text.
            "', com_created_on = '".$curr_datetime.
            "' WHERE com_comment_id = '".$id."'";
      }
      //print "CommentDataAccess update query ".$query_update."<br/>";
      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query_update);
      return $result;

    }

    public function deleteComment($comment) {
      $id = $comment->getId();
      $curr_datetime  = date('Y-m-d H:i:s');
      //$query_delete = "DELETE FROM ".COMMENT." WHERE com_comment_id = ".$id;
      $query_delete = "UPDATE ".COMMENT." SET com_is_visible = 'N', com_created_on = '".$curr_datetime."' WHERE com_comment_id = '".$id."'";
      //print ("CommentDataAccessor->deleteComment- query: ".$query_delete);
      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query_delete);
      return $result;
    }

    public function deleteCommentById($comment_id) {
      $curr_datetime  = date('Y-m-d H:i:s');
      //$query_delete = "DELETE FROM ".COMMENT." WHERE com_comment_id = ".$comment_id;
      $query_delete = "UPDATE ".COMMENT." SET com_is_visible = 'N', com_created_on = '".$curr_datetime."' WHERE com_comment_id = '".$comment_id."'";
      print ("CommentDataAccessor->deleteComment- query: ".$query_delete);
        $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query_delete);
      return $result;
    }
      
    public function getAllComments() {
      $query = "SELECT * FROM ".COMMENT." WHERE com_is_visible='Y'";
      //print("CommentDataAccessor->getAllComments->$query ");
      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comment_all = $this->getCommentList($result);
      return $comment_all;
      
    }
      
    public function getAllCommentsByDate() {
      $query = "SELECT * FROM ".COMMENT." WHERE com_is_visible='Y' ORDER BY com_created_on";
      //print("CommentDataAccessor->getAll Comments->$query ");
      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comment_all = $this->getCommentList($result);
      return $comment_all;
      
    }

    public function getCommentById($comment_id) {
      $query = "SELECT * FROM ".COMMENT." WHERE com_comment_id = ".$comment_id." AND com_is_visible='Y' ORDER BY com_created_on";

      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comment_by_id = $this->getComment($result);
      return $comment_by_id;
    }

    public function getCommentByUser($comment_created_by) {
      $query = "SELECT * FROM ".COMMENT." WHERE com_created_by = ".$comment_created_by." AND com_is_visible='Y' ORDER BY com_created_on";

      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comments_by_user = $this->getCommentList($result);
      return $comments_by_user;
    }

    public function getCommentByRating($comment_rating_id) {
      $query = "SELECT * FROM ".COMMENT." WHERE com_rating_id = ".$comment_rating_id." AND com_is_visible='Y' ORDER BY com_created_on";

      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comments_by_rating = $this->getCommentList($result);
      return $comments_by_rating;
    }

    public function getCommentByEntry($comment_entry_id) {
      echo "<br/>CommentDataAccessor entry id: ".$comment_entry_id."<br/><br/>";
      $query = "SELECT * FROM ".COMMENT." WHERE com_entry_id = '".$comment_entry_id."' AND com_is_visible='Y' ORDER BY com_created_on";
      $dbHelper = new DBHelper();
      $result = $dbHelper->executeQuery($query);
      $comments_by_entry = $this->getCommentList($result);
      return $comments_by_entry;
    }
      
    public function getComment($selectResult) {
        $comment = new Comment();
        while($list = mysqli_fetch_assoc($selectResult)){
            $comment->setId($list['com_comment_id']);
            $comment->setText($list['com_text']);
            $comment->setRatingId($list['com_rating_id']);
            $comment->setCreatedBy($list['com_created_by']);
            $comment->setEntryId($list['com_entry_id']);
        }//end while
        
        return $comment;
    }
      
    public function getCommentList($selectResult) {
        $comments = array();
        $count = 0;
        while ($list = mysqli_fetch_assoc($selectResult)) {
            $comments[$count] = new Comment();
            $comments[$count]->setId($list['com_comment_id']);
            $comments[$count]->setText($list['com_text']);
            $comments[$count]->setRatingId($list['com_rating_id']);
            $comments[$count]->setCreatedBy($list['com_created_by']);
            $comments[$count]->setEntryId($list['com_entry_id']);
            $count++;
        }
        return $comments;
        
    }

  }

?>