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

//print_r($this->c);exit;
if($this->u){
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" id="frm_user" name="frm_user" action="?com=users&view=profile">
		<input type="hidden" name="form_type" value="user_info" />
		<fieldset class="form">
		<legend>User</legend>
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="group_name">Group:</label></div><div class="col-sm-2"><input id="group_name" class="inputbox form-control" value="<?php echo $this->u['group_name'];?>" readonly /></div>
				<div class="col-sm-1"><label class="control-label" for="full_name">Name:</label></div><div class="col-sm-2"><input id="full_name" name="full_name" class="inputbox form-control" value="<?php echo $this->u['full_name'];?>" readonly /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label> </div><div class="col-sm-2"><input id="e_mail" type="email" name="e_mail" class="inputbox form-control" value="<?php echo $this->u['e_mail'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="phone">Phone:</label> </div><div class="col-sm-2"><input id="phone" name="phone" class="inputbox form-control" value="<?php echo $this->u['phone'];?>" required autocomplete="off" /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="zip_code">Zip code:</label></div><div class="col-sm-2"><input id="zip_code" name="zip_code" class="inputbox form-control" value="<?php echo $this->u['zip_code'];?>" /></div>
			<div class="col-sm-1"><label class="control-label" for="city">City:</label></div><div class="col-sm-2"><input id="city" name="city" class="inputbox form-control" value="<?php echo $this->u['city'];?>" required autocomplete="off" /></div>
			<div class="col-sm-1"><label class="control-label" for="cnic">CNIC:</label></div><div class="col-sm-2"><input id="cnic" name="cnic" class="inputbox form-control input" value="<?php echo $this->u['cnic'];?>" /></div></div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="user_address">Address:</label> </div><div class="col-sm-2"><input id="user_address" name="address" class="inputbox form-control number" value="<?php echo $this->u['address'];?>" /></div>
				<div class="col-sm-1 hide"><label class="control-label" for="print_paper_size">Paper size:</label> </div><div class="col-sm-2 hide"><input id="print_paper_size" name="print_paper_size" class="inputbox form-control" value="<?php echo $this->u['print_paper_size'];?>" required autocomplete="off" /></div>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="submit" name="update_user" id="update_user" class="btn btn-success" tabindex="-1"><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
	<form class="form-inline" method="post" name="frm_change_pass" action="?com=users&view=profile">
		<input type="hidden" name="form_type" value="change_password" />
		<fieldset class="form">
		<legend>Change Password</legend>
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="old_password">Old Password:</label></div>
				<div class="col-sm-2"><input type="password" id="old_password" name="old_password" class="inputbox form-control" value="" required autocomplete="off" /></div>
				<div class="col-sm-2"><label class="control-label" for="new_password">New Password:</label> </div>
				<div class="col-sm-2"><input type="password" id="new_password" name="new_password" class="inputbox form-control" value="" required autocomplete="off" /></div>
				<div class="col-sm-2"><label class="control-label" for="confirm_password">Confirm Password:</label> </div>
				<div class="col-sm-2"><input type="password" id="confirm_password" name="confirm_password" class="inputbox form-control" value="" required autocomplete="off" /></div>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="submit" name="update_password" id="update_password" class="btn btn-danger" tabindex="-1"><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
	<form class="form-inline" method="post" name="frm_company" action="?com=users&view=profile">
		<input type="hidden" name="form_type" value="branch_info" />
		<fieldset class="form">
		<legend>Company</legend>
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="branch_title">Title:</label></div><div class="col-sm-2"><input id="branch_title" name="title" class="inputbox form-control" value="<?php echo $this->c['title'];?>" required readonly /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="company_address">Address:</label> </div><div class="col-sm-4"><input id="company_address" name="address" class="inputbox form-control" value="<?php echo $this->c['address'];?>" required autocomplete="off" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="billing_head">Bill Heading:</label> </div><div class="col-sm-4"><input id="billing_head" name="billing_head" class="inputbox form-control" value="<?php echo $this->c['billing_head'];?>" required autocomplete="off" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="billing_address">Bill Address:</label> </div><div class="col-sm-4"><input id="billing_address" name="billing_address" class="inputbox form-control" value="<?php echo $this->c['billing_address'];?>" required autocomplete="off" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="billing_contacts">Contact info:</label> </div><div class="col-sm-4"><input id="billing_contacts" name="billing_contacts" class="inputbox form-control" value="<?php echo $this->c['billing_contacts'];?>" required autocomplete="off" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="company_address">Bill Notes:</label> </div>
				<div class="col-sm-4"><textarea id="billing_notes" class="inputbox form-control" rows="5" style="width:100%;" name="billing_notes"><?php echo $this->c['billing_notes'];?></textarea></div>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="submit" name="update_company_info" id="update_company_info" class="btn btn-info" tabindex="-1"><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php
} ?>