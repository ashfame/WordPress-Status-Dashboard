<? // Just your basic MySQL connection class
class MySQL {
	var $host;
	var $dbUser;
	var $dbPass;
	var $dbName;
	var $dbConn;
	var $connectError;
	
	function MySQL($host, $dbUser, $dbPass, $dbName)
	{
		$this->host = $host;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;
		$this->dbName = $dbName;
		$this->connectToDb();
	}
	
	function connectToDb()
	{
		if (!$this->dbConn = @mysql_connect($this->host,$this->dbUser, $this->dbPass)) {
			trigger_error('Could not connect to server: ' . mysql_error());
			$this->connectError = true;
		} 	else if (!@mysql_select_db($this->dbName,$this->dbConn)) {
			trigger_error('Could not select database: ' . mysql_error());
			$this->connectError = true;
		}
	}
	
	function isError()
	{
		if ($this->connectError) {
			return true;
		}
		$error = mysql_error($this->dbConn);
		if (empty($error)) {
			return false;
		}	else {
			return true;
		}
	}
	
	function &query($sql)
	{
		if (!$queryResource = mysql_query($sql, $this->dbConn)) {
			trigger_error('Query failed: ' . mysql_error($this->dbConn)
			. ' SQL: ' . $sql);
			return new MySQLResults($this, $queryResource);
		}
	}
}

$db = &new MySQL($host, $dbUser, $dbPass, $dbName); 
?>