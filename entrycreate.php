<?php 

//session_start();
//if(isset($_SESSION['user'])){ // 1  

  require("header.php"); 
  //include "../../config.php";
  require_once BUSINESS_DIR_ENTRY . "EntryManager.php";
  //include_once "lib.php";  // 25
  include_once 'views/entry/form_to_edit_entry.php';
  include_once 'views/entry/form_to_create_entry.php';
  
  $user_input_valid = true; // 2
  
  // 3
  $text_error = "";
  //etc...  
    
  if($_POST){ // 4
    //echo 'Entry/create.php: $_POST is populated';
 
    //------------------------------------------
    // 26
    //------------------------------------------    

    if($user_input_valid){ // 6       
            
      if($_GET['id']){ // 14
        // 41
        $em = new EntryManager(); // 12
        // 7, 8, 9, 10
      
        //table_to_see_POST_values(); // 27      
        $entry = new Entry(); // 32
        // 11, 29, 39 
        $entry->setEntryId(         $_GET['id']);
        //$entry->setEntryLanguage($_POST['language']); // 30 (?)
        $entry->setEntryText(mysql_real_escape_string((($_POST['text']))));
        //$entry->setEntryVerbatim($_POST['verbatim']);
        $entry->setEntryTranslit(mysql_real_escape_string((($_POST['translit']))));
        //$entry->setEntryAuthenStatusId($_POST['authen']);
        $entry->setEntryTranslOf(   NULL); // $_POST['transl_of']);
        //$entry->setEntryUserId(     '3'); //$_POST['creator']);
        $entry->setEntryMediaId(    '1');//($_POST['media_id']);
        $entry->setEntryCommentId(  '2'); //$_POST['comment_id'];
        $entry->setEntryRatingId(   '1'); //($_POST['rating_id']);
        $entry->setEntryTags(       $_POST['tags']);
        $entry->setEntryAuthorId(   $_POST['author']);
        $entry->setEntrySourceId(   $_POST['source']); 
        $entry->setEntryUse(        $_POST['use']);
        $entry->setEntryHttpLink(   $_POST['link']);
        // add logic to create today's date
        $entry->setEntryCreationDate("2014-10-23");
        // 40
        
        $resultOfEntryUpdate = $em->updateEntry($entry); // 33
        header("Location: index.php?id=" . $_GET['id']); // 38
        //$query = "UPDATE ..."; // 15
      }
      else{ // 16
        // 11
        $em = new EntryManager(); // 12
        // 7, 8, 9, 10
      
        //table_to_see_POST_values(); // 27      
        $entry = new Entry(); // 32
        // 11, 29
        //$entry->setEntryId($_POST['id']);
        $entry->setEntryLanguage($_POST['language']); // 30 (?)
        $entry->setEntryText($_POST['text']);
        $entry->setEntryVerbatim($_POST['verbatim']);
        $entry->setEntryTranslit($_POST['translit']);
        $entry->setEntryAuthenStatusId($_POST['authen']);
        $entry->setEntryTranslOf(NULL); // $_POST['transl_of']);
        $entry->setEntryUserId('3'); //$_POST['creator']);
        $entry->setEntryMediaId('1');//($_POST['media_id']);
        $entry->setEntryCommentId('2'); //$_POST['comment_id'];
        $entry->setEntryRatingId('1'); //($_POST['rating_id']);
        $entry->setEntryTags($_POST['tags']);
        $entry->setEntryAuthorId($_POST['author']);
        $entry->setEntrySourceId($_POST['source']); 
        $entry->setEntryUse($_POST['use']);
        $entry->setEntryHttpLink($_POST['link']);
        // add logic to create today's date
        $entry->setEntryCreationDate("2014-10-23");
        
        $id = $em->createEntry($entry); // 13
        echo "<br> Entry/create.php: the result of the insert query = ". $id;
        header("Location: index.php?id=" . $id); // 31
      
      } // create a query for INSERT operation
    } // 6
  }// 4
  else { // 17
    if($_GET['id']){ // 34
      echo "the id of the entry you want to edit is " . $_GET['id'];
      $em = new EntryManager(); // 12
      $entry = $em->getEntryById($_GET['id']); // 36
      form_to_edit_entry($entry); // 37
      
    }
    else{ // 35
      form_to_create_entry();
    }

}

require("footer.php");