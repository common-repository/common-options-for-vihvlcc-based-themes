<?php
namespace vihv;

class ExceptionControl extends Control {
	
	const DEFAULT_TEMPLATE = "vihv/design/Misc/Exception.xsl";
	
	function SetException($e)  {
		$this->Data['class'] = get_class($e);
		$this->Data['message'] = $e->getMessage();
		$this->Data['full'] = (string)$e;
		}
                
        function SetTemplate($path) {
            $this->template = $path;
        }
		
	function GetTemplate() {
		try {
			return parent::GetTemplate();
		} catch(Exception $e) {
                    if(!empty($this->template)) {
			return $this->template;
                    }
                    return self::DEFAULT_TEMPLATE;
		}
		}
	}