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


?><div class="com-head">
	<h3>Daily Overview</h3>
</div>
<div class="form"></div>
<div class="table-responsive"><div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="home" />
			<input type="hidden" name="view" value="summery" />
			<div>
			<div class="date-range">
				<input type="date" name="start_date" id="start_date"class="inputbox date-default" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success btn-lg btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
</div>
<div class="grid grid-bordered">
	<div class="row">
		<div class="col-sm-2"><strong>Headings</strong></div>
		<div class="col-sm-1"><strong>Amouont</strong></div><div class="col-sm-1"><strong>Cash</strong></div><div class="col-sm-1"><strong>Credit</strong></div>
		<div class="col-sm-1"><strong>Discount</strong></div><div class="col-sm-2"><strong>Transcations</strong></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Sales</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->row['TotalSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->row['cashSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->row['creditSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->row['DiscountSum'];?></span></div>
		<div class="col-sm-2 value"><span class="badge"><?php echo $this->row['SaleBills'];?></span>
		Disc: <span class="badge"><?php echo $this->row['countDiscount'];?></span>
		Credit: <span class="badge"><?php echo $this->row['countCredit'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Purchase returns</strong></div>
		<div class="col-sm-2 value"></div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-sm-2"><strong>Purchase</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowPur['TotalSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowPur['cashSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowPur['creditSum'];?></span></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo $this->rowPur['Bills'];?></span>
		Entered: <span class="badge"><?php echo $this->rowPur['BillClosed'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Sales returns</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowSR['TotalSum'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowSR['TotalCash'];?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowSR['TotalCredit'];?></span></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo $this->rowSR['Bills'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Expenses</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo $this->rowExp['TotalSum'];?></span></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo $this->rowExp['Bills'];?></span></div>
	</div><hr/>
</div>