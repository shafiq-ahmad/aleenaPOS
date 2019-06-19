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

import('core.application.component.view');
class ArticleViewArticles extends View{
	public $id;
	public function display($tpl = null){
		$model = $this->getModel('article');
		$m_cat = $this->getModel('categories.categories');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($this->id){
			$this->row = $model->getDataByID($this->id);
		}
		if($this->id && $_POST){
			$model->setData($_POST);
			$this->row = $model->getDataByID($this->id);
		}elseif($_POST){
			$res = $model->createData($_POST);
			if($res){
				redirect('?com=articles&view=articles');
			}
		}
		$category = 0;
		if(isset($this->row['category'])){
			$category = $this->row['category'];
		}
		$this->cats = $m_cat->getCategoriesHTML($category);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
