<?php
namespace org\opencomb\comment;

use org\jecat\framework\bean\BeanFactory;
use org\jecat\framework\message\Message;
use org\opencomb\coresystem\mvc\controller\Controller;

class CommentList extends Controller
{
	public function createBeanConfig()
	{
		$arrBean =  array(
			'title'=>'评论列表',
			'view:commentListView'=>array(
				'template'=>'comment:CommentList.html',
				'class'=>'view',
				'widget:comment_paginator' => array(
						'class' => 'paginator' ,
				) ,
				'model'=>'comment',
			),
			'model:comment'=>array(
					'class' => 'model' ,
					'list'=>'true',
					'orm' => array(
							'table' => 'comment:comment',
							'orderAsc'=>'create_time',
					) ,
			),
			
		);
		if(!$this->params->has('noform')){
			$arrBean['controllers'] = array(
				'createComment'=>array(
						'class'=>'org\opencomb\comment\CreateComment',
				)
			);
		}
		
		return $arrBean;
	}

	public function process()
	{
		$this->requireLogined();
		
		$this->modelComment->load(
			array(
				$this->params->get('tid'),
				$this->params->get('type'),
			),
			array(
				'tid',
				'type'
			)
		);
		
	}
}
?>