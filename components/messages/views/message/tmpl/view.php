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

defined('_MEXEC') or die ('Restricted Access');
//print_r($row);exit;

?><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=categories&view=categories&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="id">From:</label></div><div class="col-sm-2"><?php echo $this->row['from_name'];?></div>
				<div class="col-sm-1"><label class="control-label" for="id">Date:</label></div><div class="col-sm-2"><?php echo $this->row['time_stamp'];?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">To:</label></div><div class="col-sm-2"><?php echo $this->row['to_name'];?></div>
				<div class="col-sm-1"><label class="control-label" for="title">CC:</label></div><div class="col-sm-2"><?php echo $this->row['cc_name'];?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="title">Subject:</label></div><div class="col-sm-6"><?php echo $this->row['msg_subject'];?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-6"><?php echo htmlspecialchars_decode(stripslashes($this->row['msg_body']));?></div>
			</div>
		</div>
		</fieldset>
	</form>
</div>


