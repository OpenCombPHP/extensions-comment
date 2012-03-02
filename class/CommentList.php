<?php
namespace org\opencomb\Comment;

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
				'widget:paginator' => array(
						'class' => 'paginator' ,
				) ,
			),
		);
	}

	public function process()
	{
		$this->requireLogined();
		$arrCommentBean = array(
						'class' => 'model' ,
						'list'=>'true',
						'orm' => array(
							'table' => 'comment_comment',
							'disableTableTrans' => true,
							'limit'=>10
						) ,
					);
		$aCommentModel = BeanFactory::singleton()->createBean($arrCommentBean,'comment') ;
		$aCommentModel->load();
		$aCommentModel->printStruct();
		$this->commentListView->setModel($aCommentModel);
	}
}
?>