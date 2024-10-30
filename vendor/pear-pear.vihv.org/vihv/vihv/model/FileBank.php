<?php
namespace vihv;

require_once "vihv/model/XmlDocModel.php";


class FileBank extends XmlDocModel {

	var $KeyValue;

	function __construct() {
		parent::__construct();
		$this->KeyValue = ConfigManager::GetModel('IKeyValue', $this);
		}

	function GetDocFields() {
		return array('mime','data_id', 'name', 'size');
		}

	function Add($Input) {
		$FileName = $Input['tmp_name'];
		$Content = file_get_contents($FileName);
		$Hash = sha1($Content);
		$this->KeyValue->Save($Hash, $Content);
		$Input['data_id'] = $Hash;
		$Input['mime'] = $Input['type'];
		return parent::Add($Input);
		}

	function GetInfo($Id, $loadData = true) {
		$Info = parent::GetInfo($Id);
		if($loadData) {
			$Info['data'] = $this->KeyValue->Load($Info['value']['data_id']);
		}
		return $Info;
		}

	function GetShortInfo($Id) {
		return parent::GetInfo($Id);
		}

	function Remove($Id) {
		$Info = parent::GetInfo($Id);
		$this->KeyValue->Remove($Info['value']['data_id']);
		parent::Remove($Id);
		}

}
