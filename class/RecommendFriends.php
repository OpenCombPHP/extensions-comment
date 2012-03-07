<?php
namespace org\opencomb\Comment;

use org\jecat\framework\auth\IdManager;
use org\jecat\framework\db\sql\Order;
use org\opencomb\coresystem\mvc\controller\Controller;

class RecommendFriends extends Controller
{
/**
 * @example /MVC模式/模型/查询/随机排序
 * 
 */
	public function createBeanConfig()
	{
		return array(
			'title'=>'推荐好友',
			'view:recommendFriends'=>array(
				'template'=>'friends:RecommendFriends.html',
				'class'=>'view',
				'model'=>'users',
			),
			'model:users'=>array(
				'class' => 'model' ,
				'list'=>true,
				'orm'=>array(
					'orderRand'=>Order::rand,   //随机排序
					'table'=>'coresystem:user',
					'limit'=>4,
				)
			),
		);
	}

	public function process()
	{
		$this->users->load();
		$sUid = '';
		if($aId = IdManager::singleton()->currentId()){
			$sUid = $aId->userId();
		}
		$arrUserModels = array();
		foreach($this->users->childIterator() as $aUserModel){
			if($aUserModel['uid'] == $sUid){
				continue;
			}
			$arrUserModels[] = $aUserModel;
		}
		if(count($arrUserModels) == 4){
			array_shift($arrUserModels);
		}
		$this->recommendFriends->variables()->set('arrUserModels',$arrUserModels) ;
		
	}
}
?>