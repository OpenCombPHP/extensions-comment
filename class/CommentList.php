<?php
namespace org\opencomb\comment;

use org\jecat\framework\db\DB;

use org\jecat\framework\bean\BeanFactory;
use org\jecat\framework\message\Message;
use org\opencomb\coresystem\mvc\controller\Controller;

class CommentList extends Controller
{
	public function createBeanConfig()
	{
		return array(
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
			'controllers'=>array(
					'createComment'=>array(
						'class'=>'org\opencomb\comment\CreateComment',
					),
			),
		);
	}

	public function process()
	{
// 		if(!$this->params->has('tid') || !$this->params->has('type') ){
// 			$this->messageQueue ()->create ( Message::error, "无法定位信息,没有提供完整条件" );
// 			return;
// 		}
		
		$this->requireLogined();
		
		$sPid = '0';
		if($this->params->has('pid')){
			$sPid = $this->params->get('pid');
		}
		
		$this->modelComment->load(
				array(
					$this->params->get('tid'),
					$sPid,
					$this->params->get('type'),
				) ,
				array(
					'tid',
					'pid',
					'type'
				)
			);
	}
}
?>