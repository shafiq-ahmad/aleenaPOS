<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

//$pa =  $user->pageAccess(12);
$u=array();
if(self::$options->com != 'user' && self::$options->view != 'login'){
	$u=$this->user->getUser();
}
?>
<style>
#modal-body{padding:20px;}
</style>
<div id="modal-body"><?php
echo $this->_com;
?>
</div><script>
<?php echo $this->getScript(); ?>
</script>

