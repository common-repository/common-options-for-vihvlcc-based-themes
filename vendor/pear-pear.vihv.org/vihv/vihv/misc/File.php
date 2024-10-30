<?php
namespace vihv;

require_once 'vihv/exception/Exception.php';

class File {
	/**
	search all folders mentioned in php.ini:include_path
	@return full path of first found $Filename 
	*/
	public static function searchIncludePath($Filename) {
		$inipath = ini_get("include_path");
		$exploded = explode(PATH_SEPARATOR,$inipath);
		krsort($exploded);
		foreach($exploded as $path) {
//			var_dump($path."/".$Filename);
			if(file_exists($path."/".$Filename)) {
				return $path."/".$Filename;
				}
			}
		if(file_exists($Filename)) {
			return $Filename;
		}
		
		throw new EFileNotFoundException("File ".$Filename." not found in ".$inipath);
	}
	
	public static function getExtension($filename) {
		$exploded = explode('.',$filename);
		if(count($exploded)<2) {
			return;
		}
		return $exploded[count($exploded)-1];
	}
	
	public static function getFileWithoutExtension($filename) {
		$exploded = explode('.',$filename);
		if(count($exploded)<2) {
			return $filename;
		}
		unset($exploded[count($exploded)-1]);
		return implode('.', $exploded);
	}


	/**
	 * extract folder name from full path
	 */
	public static function getFolderNameByPath($path) { 
		$path = rtrim($path, '/');
		$exploded = explode('/',$path);
		if(count($exploded) < 1) {
			return $path;
		}
		return $exploded[count($exploded)-1];
	}
	
	public static function getChildFolders($path) {
		$dir = dir($path);
		if($dir === false) {
			throw new EFileNotFoundException($path);
		}
		$folders = array();
		while(false !== ($child = $dir->read())) {
			if($child !== '.' && $child !== '..') {
				if(is_dir($path.'/'.$child)) {
					$folders[] = $path.'/'.$child;
				}
			}
		}
		return $folders;
	}
	
	
	
	public static function getFiles($path) {
		$d = dir($path);
		$files = [];
		$navFolders = array('.', '..');
		while (false !== ($fileEntry=$d->read() )) {
			if (in_array($fileEntry, $navFolders) 
				|| is_dir($path."/".$fileEntry)
				) {
				continue;
			}
			$files[] = $fileEntry;
		}
		return $files;
	}
	
	static function copyFolder($source, $target) {
		if (!is_dir($source)) {//it is a file, do a normal copy
		    copy($source, $target);
		    return;
		}

		//it is a folder, copy its files & sub-folders
		@mkdir($target);
		$d = dir($source);
		$navFolders = array('.', '..');
		while (false !== ($fileEntry=$d->read() )) {//copy one by one
		    //skip if it is navigation folder . or ..
		    if (in_array($fileEntry, $navFolders) ) {
			continue;
		    }
		    self::copyFolder($source."/".$fileEntry, $target."/".$fileEntry);
		}
		$d->close();
	}
}

class EFileNotFoundException extends Exception {}