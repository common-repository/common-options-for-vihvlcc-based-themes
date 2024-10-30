<?php
namespace vihv;

require_once "vihv/interface/ISql.php";
require_once "vihv/interface/IMysqlConfig.php";

class Mysql implements ISql {

	function __construct(IMysqlConfig $Config) {
		$this->Config = $Config;
		$this->IsConnected = false;
		$this->Connect();
		}

	public function Select($query) {
		$re = array();
 		$result = mysql_query( $this->handle, $query );
		if(!$result) {
			throw new EMysqlException(mysql_errno( $this->handle )." ".mysql_error( $this->handle ));
			}
		if(mysql_num_rows( $result ) > 0) {
			while( $row = mysql_fetch_assoc( $result ) ){
                    		$re[] = $row;
				}
			}
		return $re; 
		}

	public function Sql($query) {
		$result = mysql_query( $this->handle, $query );
		if(!$result) {
			throw new EMysqlException(mysql_errno( $this->handle )." ".mysql_error( $this->handle ));
			}
		}

	function SelectOne($query) { //! this should go to base class for relational
		$re = $this->Select($query);
		if(count($re) != 1) {
			throw new EMysqlException('row not found');
			}
		return $re[0];
		}

	function IsConnected() {
		return $this->IsConnected;
		}

	function Connect() {
		$this->handle = @mysql_connect( $this->Config->GetHost(),
					 $this->Config->GetUser(),
					 $this->Config->GetPassword() );
		if( !$this->handle ) {
			throw new EMysqlException(mysqli_connect_errno().' '.mysqli_connect_error());
			}
		if( !@mysql_select_db( $this->handle, $this->Config->GetDbName() ) ) {
			throw new EMysqlException(mysql_errno( $this->handle )." ".mysql_error( $this->handle ));
			}
		$this->Sql("SET NAMES ".$this->Config->GetCharset());
		$this->IsConnected = true;
		}
	}

class EMysqlException extends Exception {}