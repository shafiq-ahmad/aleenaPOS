<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class RestoredbViewSetup extends View{
	public $id=0;
	public function display($tpl = null){
		define("BACKUP_DIR", SITE_PATH); // Comment this line to use same script's directory ('.')
		define("BACKUP_FILE", 'myphp-backup-webapplics_pos-20181022_164459.sql.gz'); // Script will autodetect if backup file is gzipped based on .gz extension
		$this->app = core::getApplication();
		$this->app->setTitle('Restore DBs');
		
		parent::display($tpl);
	}
}
