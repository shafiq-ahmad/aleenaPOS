<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.database.backup');
import('core.application.component.view');
class BackupdbViewSetup extends View{
	public $id=0;
	public function display($tpl = null){
		$bak_path = SITE_PATH . DS . 'db_bak';

		define("BACKUP_DIR", $bak_path); // Comment this line to use same script's directory ('.')
		define("TABLES", '*'); // Full backup
		//define("TABLES", 'table1, table2, table3'); // Partial backup
		$this->app = core::getApplication();
		$this->app->setTitle('Backup DBs');
		
		parent::display($tpl);
	}
}
