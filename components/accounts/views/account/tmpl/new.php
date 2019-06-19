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
//print_r($cats);exit;
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div>
<div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=articles&view=article&task=edit">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="article_code">Item#:</label></div><div class="col-sm-2"><input id="article_code" name="article_code" class="inputbox form-control" value=""  data-validation="number" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="ref_code">Ref#:</label> </div><div class="col-sm-2"><input id="ref_code" name="ref_code" class="inputbox form-control" value="" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="comments">Comments:</label> </div><div class="col-sm-2"><input id="comments" name="comments" class="inputbox form-control" value="" /></div>
			</div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="title">Title:</label></div><div class="col-sm-2"><input id="title" name="title" class="inputbox form-control" value="" data-validation="length" data-validation-length="min5" /></div>
			<div class="col-sm-2"><label class="control-label col-sm-2" for="category">Category:</label> </div><div class="col-sm-2"><?php 
			
			echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
			echo '<OPTION value="">Please select a value</OPTION>';
			foreach ($this->cats as $cat){
				echo '<optgroup label="' . $cat['name'] . '">';
				foreach ($cat as $c){
					print_r($c);echo '<br/>';
				}
				echo '</optgroup>';
			}
			echo '</SELECT>';
			
			
			?></div><div class="col-sm-2"><label class="control-label" for="brand">Brand:</label> </div><div class="col-sm-2"><input id="brand" name="brand" class="inputbox form-control input" value="" /></div></div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="size">Size:</label> </div><div class="col-sm-2"><input id="size" name="size" class="inputbox form-control number" value="" /></div><div class="col-sm-2"><label class="control-label col-sm-2" for="unit">Unit:</label> </div><div class="col-sm-2"><input id="unit" name="unit" class="inputbox form-control" value="" /></div><div class="col-sm-2"><label class="control-label col-sm-2" for="packing">Packing:</label> </div><div class="col-sm-2"><input id="packing" name="packing" class="inputbox form-control number" value="" /></div></div>
			
			<div class="row well-sm"><label class="control-label col-sm-2" for="add_stock_record">Create Stock Record:</label><div class="col-sm-2"><input type="checkbox" id="add_stock_record" name="add_stock_record" class="checkbox form-control input-sm col-sm-1" /></div></div>
			
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="cost_price">Cost Price:</label></div><div class="col-sm-2"><input id="cost_price" name="cost_price" class="inputbox form-control" value="0" data-validation="number" /></div>
				<div class="col-sm-2"><label class="control-label" for="whole_sale_price">W.Sale Price:</label> </div><div class="col-sm-2"><input id="whole_sale_price" name="whole_sale_price" class="inputbox form-control" value="0" /></div>
				<div class="col-sm-2"><label class="control-label" for="sale_price">Sale Price:</label> </div><div class="col-sm-2"><input id="sale_price" name="sale_price" class="inputbox form-control" value="0" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="min_stock">Min Stock:</label></div><div class="col-sm-2"><input id="min_stock" name="min_stock" class="inputbox form-control" value="0" data-validation="number" /></div>
				<div class="col-sm-2"><label class="control-label" for="max_stock">Max Stock:</label> </div><div class="col-sm-2"><input id="max_stock" name="max_stock" class="inputbox form-control" value="0" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="loc_section">Loc Section:</label></div><div class="col-sm-2"><input id="loc_section" name="loc_section" class="inputbox form-control" value="" /></div>
				<div class="col-sm-2"><label class="control-label" for="loc_rack">Loc Rack:</label> </div><div class="col-sm-2"><input id="loc_rack" name="loc_rack" class="inputbox form-control" value="" /></div>
				<div class="col-sm-2"><label class="control-label" for="loc">Location:</label> </div><div class="col-sm-2"><input id="loc" name="loc" class="inputbox form-control" value="" /></div>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()" tabindex="-1" /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" tabindex="-1" /></span>
				<span><input type="submit" name="save" id="save" class="btn btn-success" value="Save" tabindex="-1" /></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div>