<?php
/**
* @Author Rian (godamri@gmail.com)
*/
class Database
{
	/*
	* Database credentials
	*/
	private $host = '127.0.0.1';
	private $user = 'root';
	private $database = 'illusion_sample';
	private $password = '';

	/*
	* Other private stuff
	*/
	private $connection=null;

	function __construct()
	{
		/*
		* Test Connection
		*/
		try{
			$this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
			if ($this->connection->connect_errno) {

				/*
				* Throw error message
				*/
				throw new Exception($this->connection->connect_error);

			}
		}
		catch (Exception $e){

			echo "<h1> Error estabilishing database connection : " . $e->getMessage() . "</h1>";

		}
	}
	function __destruct()
	{

		$this->connection->close();

	}

	public function getAll($table=null)
	{
		/*
		* Set default table name same as db name
		*/
		$table = ( $table == null ) ? $this->database : $table;
		$q = "SELECT * FROM $table";
		$d = array();
		$result = $this->connection->query($q);
		if ($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				$d[] = $row;
			}
		}
		if (count($result)>0) {
			return $d;
		}
		return false;
	}

	public function getOne($table=null,$where=null)
	{
		if ( $where == null) return false;
		
		/*
		* Set default table name same as db name
		*/
		$table = ( $table == null ) ? $this->database : $table;
		
		$q = "SELECT * FROM $table WHERE $where LIMIT 1";
		$result = $this->connection->query($q);
		if ($result) {
			return $result->fetch_assoc();
		}
		return false;
	}

	public function update($table=null,$where=null,$data=null)
	{
		if ( $where == null) return false;
		if ( $data == null) return false;
		$update = '';
		/*
		* Set default table name same as db name
		*/
		$table = ( $table == null ) ? $this->database : $table;

		/*
		* Build received data into query
		*/
		foreach ($data as $key => $value) {
				$update .="`$key` = '$value',";
		}
		$update = rtrim($update, ",");

		$q = "UPDATE $table SET $update WHERE $where";
		$result = $this->connection->query($q);
		if ($result) {
			return true;
		}
		return false;
	}

	public function delete($table=null,$where=null)
	{
		if ( $where == null) return false;

		/*
		* Set default table name same as db name
		*/
		$table = ( $table == null ) ? $this->database : $table;
		if ($where == 'DROP' )
		{
			$q = "DELETE FROM $table";
		}
		else {
			$q = "DELETE FROM $table WHERE $where";	
		}
		$result = $this->connection->query($q);
		if ($result) {
			return true;
		}
		return false;
	}

	public function insert($table=null,$data=null)
	{
		if ( $data == null) return false;
		$fields = '';
		$values = '';

		/*
		* Set default table name same as db name
		*/

		$table = ( $table == null ) ? $this->database : $table;

		/*
		* Build received data into query
		*/
		foreach ($data as $key => $value) {
				$value = mysqli_real_escape_string($this->connection,$value);
				$fields .="`$key`,";
				$values .="'$value',";
		}

		$fields = "(" . rtrim($fields,',') . ")";
		$values = "(" . rtrim($values,',') . ")";
		$q = "INSERT INTO $table $fields VALUES $values";
		$result = $this->connection->query($q);
		if ($result) {
			return $this->connection->insert_id;
		}
		return false;
	}


	public function getAllBy($table=null,$where=null,$order=null,$limit=null)
	{
		/*
		* Set default table name same as db name
		*/
		$table = ( $table == null ) ? $this->database : $table;
		$where = ( $where == null ) ? "" : "WHERE " . $where;
		$order = ( $order == null ) ? "" : " ORDER BY " . $order;
		$limit = ( $limit == null ) ? " LIMIT 0,30 " : " LIMIT " . $limit;

		$q = "SELECT * FROM $table $where $order $limit";
		$d = array();
		$result = $this->connection->query($q);
		if (isset($result->num_rows) AND $result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				$d[] = $row;
			}
		}
		if (count($result)>0) {
			return $d;
		}
		return false;
	}

}