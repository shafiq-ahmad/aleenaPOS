<?php
defined('_MEXEC') or die ('Restricted Access');

require_once("functions.php");
require_once ('mongodb/autoload.php');

import('core');
import('core.mobject');
import('core.application');
import('core.database');
import('core.user');
require_once 'settings.php';

//$db = Core::getDBO();
$user = new User();

?>