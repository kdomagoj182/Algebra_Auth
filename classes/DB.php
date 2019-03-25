<?php

class DB
{
	private static $instance=null;
	private $config;
	private $conn;
	private $query;
	private $error=false;
	private $results;
	private $count_row=0;
	
	# Construct
	private function __construct()
	{
		$this->config=Config::get('database');
		
		$driver=$this->config['driver'];
		$host=$this->config[$driver]['host'];
		$db=$this->config[$driver]['db'];
		$charset=$this->config[$driver]['charset'];
		
		$dsn=$driver.':host='.$host.';dbname='.$db.';charset='.$charset;
		$user=$this->config[$driver]['user'];
		$pass=$this->config[$driver]['pass'];
		
		try{
			$this->conn=new PDO($dsn, $user, $pass);
		}	catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	# Clone
	private function __clone(){}  #zabranjuje kloniranje objekata
	
	# getInstance
	public static function getInstance()
	{
		if(!self::$instance){
			self::$instance=new self();
		}
		
		return self::$instance;
	}
	
	/* 
	* Create database query
	* 
	* @param string $sql
	* @param array $params
	* @return object DB
	*/
	
	public function query($sql, $params=array())
	{
		// Reset property error to false
		$this->error=false;
		
		// Create prepare statement and add to property query
		if($this->query=$this->conn->prepare($sql)){
			
			// Bind value to param placeholders
			if(!empty($params)){
				$x=1;  // indeks upitnika - predstavlja "?" (WHERE name=? AND password=?', array($user, $pass)));
				foreach($params as $param){
					$this->query->bindValue($x, $param);
					$x++;
				}
			}
			// Execute prepared statement
			if($this->query->execute()){
				$this->results=$this->query->fetchAll($this->config['fetch']);
				$this->count_row=$this->query->rowCount();
			} else{
				$this->error=true;
			}
		} else {
			$this->error=true;
		}
		
		return $this; // vraća cijeli DB objekt
		
	}
	
	/**
	* Run database queries
	*
	* @param string $action
	* @param string $table
	* @param array $where
	* return DB or false
	*/
	
	private function action($action, $table, $where=array())
	{
		// Check $where array elements
		if(count($where)===3){
			// Allow operators
			$operators=array('=','<','>','<=','>=');
			// Separate $where array data to variables
			$field=$where[0];
			$operator=$where[1];
			$value=$where[2];
			
			if(in_array($operator,$operators)){
				// Generate SQL
				$sql="{$action} FROM {$table} WHERE {$field}{$operator}?";
				// Send SQL to query method and check for errors
				if(!$this->query($sql,array($value))->error){
					return $this;				
				}
			}
		} else {
			// Generate SQL
			$sql="{$action} FROM {$table}";
			// Send SQL to query method and check for errors
			if(!$this->query($sql)->error){
				return $this;				
			}
		}
		return false;
	}
	
	
	/* GETTERS */
	
	# conn
	public function conn()
	{
		return $this->conn;
	}
	
	# error
	public function error()
	{
		return $this->error;
	}
	
	# results
	public function results()
	{
		return $this->results;
	}
	
	# countRow
	public function countRow()
	{
		return $this->count_row;
	}
}