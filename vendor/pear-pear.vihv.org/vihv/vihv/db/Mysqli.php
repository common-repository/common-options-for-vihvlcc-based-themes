<?php
namespace vihv;

require_once "vihv/interface/ISql.php";
require_once "vihv/interface/IMysqlConfig.php";
require_once 'vihv/exception/Exception.php';

class Mysqli implements ISql {

	function __construct(IMysqlConfig $Config) {
		$this->Config = $Config;
		$this->IsConnected = false;
		$this->Connect();
		}
		
	public function Log($method, $query) {
//		return;
//		throw new Exception('here we are');
		if(!class_exists("\\vihv\\DebugControl")) {
//			echo "Not exists";
			return;
		}
		$debugger = DebugControl::getInstance();
//		$bc = debug_backtrace(null, 10);
//		$bcre = [];
//		foreach($bc as $item) {
//			$bcre[] = ['file'=> $item['file'], 'line' => $item['line']];
//		}
//		var_dump($bcre);
		$debugger->Data['sql'][] = [
		    'method' => $method,
		    'query' => Xml::cdata($query),
//		    'backtrace' => $bcre
		];
//		var_dump([$method, $query]);
//		var_dump($debugger->Data['sql']);
	}

	public function Select($query) {
		$this->Log('Select', $query);
		$re = array();
 		$result = mysqli_query( $this->handle, $query );
		if(!$result) {
			throw new EMysqliException(mysqli_errno( $this->handle )." ".mysqli_error( $this->handle ));
			}
		if(mysqli_num_rows( $result ) > 0) {
			while( $row = mysqli_fetch_assoc( $result ) ){
                    		$re[] = $row;
				}
			}
		return $re; 
		}

	public function Sql($query) {
		$this->Log('Sql', $query);
		$result = mysqli_query( $this->handle, $query );
		if(!$result) {
			throw new EMysqliException(mysqli_errno( $this->handle )." ".mysqli_error( $this->handle ));
			}
		}

	function Insert( $query ) {
		$Id = "-1";
		$this->openTransaction();
		$this->Sql( $query );
		$re = $this->Select("SELECT LAST_INSERT_ID() AS id");
		$Id = $re[0]['id'];
		$this->commitTransaction();
		return $Id;
		}

	function SelectOne($query) { //! this should go to base class for relational
		$re = $this->Select($query);
		if(count($re) != 1) {
			throw new EMysqliException('row not found');
			}
		return $re[0];
		}

	function IsConnected() {
		return $this->IsConnected;
		}

	function Connect() {
		//trigger_error('MysqliConnect',E_WARNING);
		$this->handle = mysqli_connect( $this->Config->GetHost(),
					 $this->Config->GetUser(),
					 $this->Config->GetPassword() );
		if( !$this->handle ) {
			throw new EMysqliException(mysqli_connect_errno().' '.mysqli_connect_error());
			}
		if( !@mysqli_select_db( $this->handle, $this->Config->GetDbName() ) ) {
			throw new EMysqliException(mysqli_errno( $this->handle )." ".mysqli_error( $this->handle ));
			}
		$this->Sql("SET NAMES ".$this->Config->GetCharset());
		$this->IsConnected = true;
		}

        public function openTransaction(){
		mysqli_autocommit( $this->handle, FALSE );
        	}
        
        public function commitTransaction(){
		mysqli_commit( $this->handle );
		mysqli_autocommit( $this->handle, TRUE );
        	}
	}

class EMysqliException extends Exception {}