<?php

class Application_Model_DbTable_Dbrestore extends Zend_Db_Table_Abstract
{
	public function getRestoreDatabase($file_name){
			$db = $this->getAdapter();
			$part =  PUBLIC_PATH;
			$str =  file_get_contents($part.'/'.$file_name);
			$strresult=$db->query($str);
			unlink($part.'/'.$file_name);
// 			return $r;
	}

	public function UploadFileDatabase($data){
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$adapter->setDestination(PUBLIC_PATH);
		$fileinfo=$adapter->getFileInfo();
 		$rs = 1;//$adapter->receive();
		if($rs==1){
			print_r();
// 			$file_name = $fileinfo['fileToUpload']['name'];
// 			$this->getRestoreDatabase($file_name);
			return true;
		}else{
			return false;
		}
	}
	//public function deleteFile(){
	// 		$part =  PUBLIC_PATH;
	// 		unlink($part.'/db_cs2_5.sql');
	// 		return 1;
	// 	}
}

