<?php
	require_once DATA_ACCESSOR_DIR . 'constants.php';
	//require_once 'constants.php';
	// Step 1. Create a Database connection
	class DBHelper{
		private $connection;
	
		private function connectToDB(){
			$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
			if(!$this->connection)
			{
				die("Database connection failed:" . mysql_error());
			}
			// Step 2. Select a Database to use
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if(!$db_select)
			{
				die("Database selection failed:" . mysql_error());
			}
		}
	 	private function closeConnection(){
			
			if(isset($this->connection)){
				mysql_close($connection);
			}
		}
	
		public function executeSelect($sql){
			$this->connectToDB();
			$result = mysql_query($sql);
			$this->closeConnection();
			return $result;
		}
	
		public function executeQuery($sql){
			$this->connectToDB();
			$result = mysql_query($sql);
			$this->closeConnection();
			return $result;
		}
	}
	
?>