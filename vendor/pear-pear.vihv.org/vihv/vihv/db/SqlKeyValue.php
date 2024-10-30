<?php
namespace vihv;
require_once "vihv/interface/IKeyValue.php";
//require_once "vihv/db/TMysqli.php";

class SqlKeyValue implements IKeyValue {
	
	public function getTableName() {
		return str_replace('\\','', strtolower(get_class($this)));
	}

	function __construct() {
                //echo "kv1";
		$this->Mysql = ConfigManager::GetModel('IMysql', $this);/*new TMysqli(new TMysqliConfig());*/
                //echo "kv2";
		$this->Mysql->Sql("
			CREATE TABLE IF NOT EXISTS `".$this->getTableName()."` (
				`key` varchar(255) primary key,
				`value` longtext
				)
			");
		}

	public function Save($Key, $Value) {
		$this->Mysql->Sql("
			INSERT INTO
				".$this->getTableName()."
			SET
				`key` = '".$Key."',
				`value` = '".base64_encode($Value)."'
			ON DUPLICATE KEY UPDATE
				`value` = '".base64_encode($Value)."'
			");
		}

	public function Load($Key) {
		$re = $this->Mysql->Select("
			SELECT
				`value`
			FROM
				".$this->getTableName()."
			WHERE
				`key` = '".$Key."'
			LIMIT 1
			");
		if(count($re) == 1) { 
			return base64_decode($re[0]['value']);
			}
		return "";
		}

	public function Remove($Key) {
		$this->Mysql->Sql("
			DELETE FROM
				`".$this->getTableName()."`
			WHERE
				`key` = '".$Key."'
			LIMIT 1
			");
		}
	}