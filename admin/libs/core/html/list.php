<?php
defined('APP_EXEC') or die('No direct access is allowed.');

class Html {

	public static function htmlList($list, $sel_id=0, $name, $class="comboBox", $first=false){
		$result='';
		$result = '<select id="' . $name . '" class="' . $class . '" name="' . $name . '" >';
			if($first){
				$result .= '<option value="0" >Select A ' . $name . '</option>';
			}
		
		foreach ($list as $row):
			$result .= '<option value="' . $row->id . '" ' ;
				if($row->id==$sel_id){
					$result .= 'selected="selected"';
				} 
				$result .= '>';
				$result .= $row->name;
			$result .= '</option>';
		 endforeach; 
		$result .= '</select>';
		
		return $result;
	}

	public static function htmlFormList($list, $name, $class, $form, $sel_id=0){
		$result='';
		$result = '<select id="' . $name . '" class="' . $class . '" name="' . $name . '" ';
		$result .= 'onChange="' . $form . '.submit();" >';
			//$result .= '<option value="0" >Select A ' . $name . '</option>';
		
		foreach ($list as $row):
			$result .= '<option value="' . $row->id . '" ' ;
				if($row->id==$sel_id){
					$result .= 'selected="selected"';
				} 
				$result .= '>';
				$result .= $row->name;
			$result .= '</option>';
		 endforeach; 
		$result .= '</select>';
		
		return $result;
	}

}

	
?>