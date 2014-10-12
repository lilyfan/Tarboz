    	<?php
			// Include utility files
			require_once '../config.php';	
			require_once BUSINESS_DIR_USER. 'User.php';	
			require_once BUSINESS_DIR_USER_LOGIN . 'UserLoginManager.php';

				//$_POST['userid']="johnsmith";
				//$_POST['password']="habib";
				//print_r($_POST);
				$userid=isset($_POST['userid']) ? $_POST['userid'] : "";
				$pwd=isset($_POST['password']) ? $_POST['password'] : "";


				$userManager = new UserLoginManager();

				$logged = $userManager->userLogin($userid,$pwd);

				//echo 'here userId: '.$userid.' pwd: '.$pwd.' user first name:'.$logged->getFirstName()."\n";	
				
				if(!empty($logged)){
					session_start();
					$_SESSION['userid']= $userid;
					$_SESSION['loggedin']="y";
					$id = session_id();
					//echo SUCCESS;
					echo $logged->getFirstName();
					//echo $_SESSION['userid'];
				}else{  echo FAIL; }

//				echo "\nThe user is:".$_SESSION["user"]->getFirstName();

													
			?>