<?php
namespace org\opencomb\comment;

use org\jecat\framework\system\Application;

use org\jecat\framework\auth\IdManager;
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
							'orderDesc'=>'create_time',
					) ,
			),
			
		);
		
		//只有已登录和需要表单的情况下才显示表单
		if(!$this->params->has('noform')){// && IdManager::singleton()->currentId()){
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
		if(!$this->params->has('tid')){
			$this->messageQueue ()->create ( Message::error, "缺少信息,无法找到评论" );
			return;
		}
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