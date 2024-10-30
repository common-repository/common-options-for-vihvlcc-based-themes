<?php
namespace vihv;
/*require_once "func/classes/models/TModel.php";*/
require_once "vihv/model/filter/DefaultDocFilter.php";
require_once "vihv/misc/Xml.php";

class XmlDocModel {
	/**
	v2 changed to Xml
	*/

	var $Filter;
	
	
	public function getTableName() {
		return str_replace('\\','', strtolower(get_class($this)));
	}

	function __construct() {
		$this->Mysql = ConfigManager::GetModel("IMysql", $this);
		$this->Mysql->Sql("
			CREATE TABLE IF NOT EXISTS
				`".$this->getTableName()."` (
				id int(11) auto_increment primary key,
				creation_time datetime,
				value text
				) DEFAULT CHARSET UTF8
			");
		$this->Filter = $this->CreateDefaultFilter();
		}

	/* abstract */
	function GetDocType() {
		return $this->getTableName();
		}
	function GetDocFields() { throw new Exception('GetDocFields() NotImplemented'); }
	function GetDocErasableFields(){ return array(); }
	function GetHtmlFields() { return array(); }

	/* regular */
	function GetFilter() {
		return $this->Filter;
		}

	function CreateDefaultFilter() {
		$Filter = new DefaultDocFilter();
		$Filter->OrderBy->Append("`".$this->getTableName()."`.creation_time", "DESC");
		return $Filter;
		}


	function Add($Arr) {

		$Fields = $this->GetDocFields();
		foreach($Fields as $cur) {
			$ToAdd[$cur] = $Arr[$cur];
			}
		$Json = Xml::MakeTree($ToAdd,'root');
		$request = "
			INSERT INTO
				`".$this->getTableName()."`
				(value, creation_time)
			VALUES (
				'".$Json."',
				NOW()
				)
			";
		return $this->Mysql->Insert($request);
		}

	function GetList() {
		$Filter = $this->GetFilter();		
		$request = "
			SELECT
				*
			FROM
				".$this->getTableName()." ".$Filter;
//		echo $request;
		$re = $this->Select($request);
		return $re;
		}

	function GetLastInsertElement() {
		$Filter = $this->CreateDefaultFilter();
		$request = "
			SELECT
				*
			FROM
				".$this->getTableName()."
			".$Filter."
			LIMIT 1
			";
		$re = $this->SelectOne($request);
		return $re;
		}

	function GetInfo($Id) {
		$request = "
			SELECT
				*
			FROM
				".$this->getTableName()."
			WHERE
				`id` = '".$Id."'
			LIMIT 1
			";
		$re = $this->SelectOne($request);
		return $re;
		}

	function Update($Id,$Arr) {
		
		$Item = $this->GetInfo($Id);
		$Value = $Item['value'];
		$Keys = array();
		foreach($Value as $key=>$val) {
			$Keys[] = $key;
			}
		$Keys = array_merge(array_diff($this->GetDocFields(),$Keys), $Keys);

		foreach($Keys as $key) {
			if(!empty(@$Arr[$key])) {
				$Value[$key] = $Arr[$key];
				}
			}

		$EFields = $this->GetDocErasableFields();

		if(!empty($EFields)) {
			foreach($EFields as $Ef) {
				if(empty($Arr[$Ef])) {
					$Value[$Ef] = '';
					}
				}
			}

		$this->RawUpdate($Id,$Value);
		}

	function Clear() {
		$this->Mysql->Sql("TRUNCATE TABLE `".$this->getTableName()."`");
		}

	function Remove($Id) {
		$request = "
			DELETE FROM
				".$this->getTableName()."
			WHERE
				`id`='".$Id."'
			LIMIT 1
			";
		$this->Mysql->Sql($request);
		}

	function RawUpdate($Id, $ToAdd) {
		$Json = \vihv\Xml::MakeTree($ToAdd,'root');
		$request = "
			UPDATE
				".$this->getTableName()."
			SET
				`value`='".$Json."'
			WHERE
				`id`='".$Id."'
			LIMIT 1
			";
		$this->Mysql->Sql($request);
		}

	function Count($Type = "") {
		if($Type == "") {
			$Type = $this->GetDocType();
			}
		$request = "
			SELECT
				COUNT(*) AS c
			FROM
				".$this->getTableName()."
			";
		$re = $this->Mysql->Select($request);
		return $re[0]['c'];
		}

	function Select($Query) {
		/**
		this method calls $this->Mysql->Select
		and do a proper conversion of Value field
		*/
		$re = $this->Mysql->Select($Query);
		//for($i=0;$i<$re['count'];$i++) {
		foreach($re as $i=>$val) {
			$re[$i]['value'] = \vihv\Xml::ToArray($re[$i]['value']);
			}
		return $re;
		}

	function SelectOne($Query) {
		/**
		calls $this->Mysql->Select and do proper convertion of Value
		*/
		$re = $this->Mysql->SelectOne($Query);
		//print_r($re);
		$re['value'] = \vihv\Xml::ToArray($re['value']);
		return $re;
		}

	}
?>