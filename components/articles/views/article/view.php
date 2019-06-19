<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ArticleViewArticles extends View{
	public $id;
	public function display($tpl = null){
		$model = $this->getModel('article');
		$this->app = core::getApplication();
		//$tmpl = Application::$options->tmpl;
		$m_cat = $this->getModel('categories.categories');
		$m_lists = $this->getModel('lists.lists');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if(!$this->id && isset($_POST['article_code'])){
			$this->id = $_POST['article_code'];
		}
		if($this->id){
			$this->row = $model->getArticleByID($this->id);
		}
		if($this->id && isset($_POST['save-article'])){
			$model->setData($_POST);
			$this->row = $model->getDataByID($this->id);
		}elseif(isset($_POST['save-article']) || isset($_POST['save'])){
			//print_r($_POST);exit;
			$res = $model->createData($_POST);
			$this->id =$res;
			if(isset($_POST['add_stock_record']) && $_POST['add_stock_record']){
				$model_ba = $this->getModel('articles.branch_article');
				$model_ba->createRecord($_POST);
				//core::getApplication()->redirect('?com=articles&view=branch_article&task=edit&id=' . $this->id);
				$this->app->redirect('?com=articles&view=article&task=new&tmpl=js_win');
			}
			if($res){
				$this->app->redirect('?com=articles&view=article&task=edit&id=' . $res);
			}
		}
		$category = 0;
		if(isset($this->row['category'])){
			$category = $this->row['category'];
		}
		$this->cats = $m_cat->getCategoriesHTML($category);
		$this->tags = $m_lists->getTags();
		$this->seasons = $m_lists->getSeasons();
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
