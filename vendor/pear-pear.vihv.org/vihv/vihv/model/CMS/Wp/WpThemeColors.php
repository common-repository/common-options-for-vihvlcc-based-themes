<?php

namespace vihv;

class WpThemeColors {
	
	function getColors() {
		$content = file_get_contents('config/colors.vihv', true);
		$rows = explode("\n", $content);
		foreach($rows as $row) {
			if(!empty($row)) {
				$args = explode(';', $row);
				if(!empty($args[1])) {
					$temp['title'] = $args[1];
				}
				$args = explode('#',$args[0]);
				$temp['name'] = str_replace('@','',$args[0]);
				$temp['default'] = "#".$args[1];
				$result[] = $temp;
			}
		}
		return $result;
	}
}

