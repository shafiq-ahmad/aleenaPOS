<?php
/**
Package: WebApplics Core System (Framework)
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

//Turn off all error reporting
//error_reporting(0);
// Report all errors
error_reporting(E_ALL);
// Same as error_reporting(E_ALL);
//ini_set("error_reporting", E_ALL);
define('_MEXEC', 1);
define('_CLIENT', 'site');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) );
//Call Framework
require_once BASE_PATH . DS . 'includes' . DS . 'defines.php';
require_once ADMIN_PATH . DS . 'libs' . DS . 'libs.php';
$app = core::getApplication();
//$user = core::getUser();
//echo Application::$client;
//print_r($_SESSION);
//exit;
$app->render();
