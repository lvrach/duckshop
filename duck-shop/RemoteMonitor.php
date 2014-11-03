<?php

/*Include dependencies */

require(__DIR__.'/vendor/autoload.php');

class RemoteMonitor {

	private $loop = null;
	private $port = 0 ;
	private $dnode = null;
	private $id = 0 ;

	//for mysql API
	private $mysql_connection = null;
	private $mysql_selected_db = "";


	public function __construct ($port) {
		
		$this->loop = new React\EventLoop\StreamSelectLoop();

		$this->port = $port;
		$this->dnode = new DNode\DNode($this->loop,$this);
		
		
		$id = &$this->id;
		
		$this->dnode->connect($this->port, function($remote, $connection) use(&$id) {
	
			$globals = array(
						"server" => $_SERVER,
						"files" => $_FILES, 
						"cookie" => $_COOKIE ,
						"request" => $_REQUEST 
					);
			
			$remote->start(function($pid) 
						use (&$id,$connection,$remote,$globals) {
					
					$id = $pid;
					$remote->info($id,$globals);		
					$connection->end();						
					
			});	
			
		});	
		
		$this->loop->run();

	}
	
	public function log ($msg, $level = 1, $type = 'log') {

		$this->dnode->connect($this->port, function($remote, $connection) 
													use ($msg,$level,$type) {
			
			$remote->report($type,$level,$msg);
			$connection->end();
		});
		$this->loop->run();


	}
	
	private function includeLog ($type, $file) {
		
		$id = $this->id;
		$this->dnode->connect($this->port, function ($remote, $connection) 
											use ($id, $type, $file) {
			
			$remote->includeLog($id, $type, $file); 	
			$connection->end();
		});
		$this->loop->run();
		
	}
	public function _include($file) {
		
		includeLog("include", $file);
		include($file);
		
	}
	public function _include_once($file) {
		
		includeLog("include_once", $file);
		include_once($file);
		
	}
	public function _require($file) {
		
		includeLog("require", $file);
		require($file);
		
	}
	public function _require_once($file) {
		
		includeLog("require_once", $file);
		require_once( $file );
		
	}
	
	
	
	private function sqlLog ($type,$parameters,$status = "success", $result = "") {

		$id = $this->id;
		$this->dnode->connect($this->port, function($remote, $connection) 
											use ($id, $type, $parameters, $status, $result) {
			
			$remote->sqlLog($id, $type, $parameters, $status, $result); 	
			$connection->end();
		});
		$this->loop->run();

	}

	public function mysql_connect($server, 
							$username = "",
							$password = "",
							$new_link = false, $client_flags = 0 ) {
			
		$mysql_connection = mysql_connect($server,$username,$password);
		$param = array(
				"server" => $server ,
				"username" => $username , 
				"password" => $password	,
				"new_link" => $new_link ,
				"client_flags" => $client_flags
			);
		
		if (!$mysql_connection) {
					
			$this->sqlLog("connection",$param,"error",mysql_error());
			throw new Exception(mysql_error());

		}
		$this->mysql_connection = $mysql_connection ;
		$this->sqlLog("connection", $param, "success","");
		return $mysql_connection ;
				
	}

	public function mysql_query($query, $link_identifier = NULL ) {
		

		$result = mysql_query($query);
		$param = array(
			"query" => $query ,
			"link_identifier" => $link_identifier 				
			);
		if (!$result) {
			$this->sqlLog("query", $param, "error", mysql_error());
			throw new Exception(mysql_error());
		}

		$this->sqlLog("query", $param, "success", "" );
		return $result ;

	}

	public function mysql_select_db($db_name, $link_identifier = NULL ) {
		

		$db_selected = mysql_select_db($db_name, $link_identifier );
		if(!$db_selected) {
			$this->sqlLog("select_db", $dbname, "error" , mysql_error());
			throw new Exception(mysql_error());
		}

		$this->sqlLog("select_db", $dbname , "success" , $dbname );
		$mysql_selected_db = $db_selected ;		
		return $db_selected ;


	}




}
	
