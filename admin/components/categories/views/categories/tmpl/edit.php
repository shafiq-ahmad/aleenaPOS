<?php
defined('_MEXEC') or die ('Restricted Access');
?><div class="com-head">
	<h3>Add/Edit Category</h3>
</div><div>
	<form>
		<ul class="form">
			<input type="hidden" name="id" value="" />
			<li><span class="left">Cat Code</span><input name="cat_code" class="inputbox" /><span class="mid"> Authority </span><input name="authoriy" class="inputbox" /></li>
			<li><span class="left">Cat Name </span><input name="title" class="inputbox" /></li>
			<li><span class="left">Cat Name Urdu </span><input name="title_urdu" class="inputbox" /></li>
			<li><span class="left">Discount % </span><input name="discount_per" class="inputbox" /><span class="mid"> GST % </span><input name="gst" class="inputbox" /></li>
		</ul>
		<ul class="buttons">
			<li>
				<span><input type="submit" name="new" id="new" class="button" value="New" /></span>
				<span><input type="submit" name="update" id="update" class="button" value="Update" /></span>
				<span><input type="submit" name="delete" id="delete" class="button" value="Delete" /></span>
			</li>
			<li></li>
		</ul>
	</form>
</div><?php 
?>