<?php
namespace org\opencomb\Comment;

use org\jecat\framework\bean\BeanFactory;
use org\jecat\framework\mvc\view\DataExchanger;
use org\jecat\framework\message\Message;
use org\opencomb\coresystem\mvc\controller\Controller;

class CreateComment extends Controller
{
	public function createBeanConfig()
	{
		return array(
			'title'=>'创建评论',
			'view:commentView'=>array(
				'template'=>'comment:CreateComment.html',
				'class'=>'form',
				'widgets'=>array(
					array(
						'id'=>'comment_content',
						'class'=>'text',
						'type'=>'multiple',
						'title'=>'内容',
						'exchange'=>'content',
						'verifier:notempty'=>array(),
// 						'verifier:length'=>array(
// 								'min'=>2)
					),
				),
			),
		);
	}

	public function process()
	{
		if ($this->commentView->isSubmit ( $this->params ))
		{
			do
			{
				//登录?
				$this->requireLogined();
				
				if(!$this->params->has('tid') || !$this->params->has('pid') || !$this->params->has('type') ){
					$this->messageQueue ()->create ( Message::error, "保存失败,没有提供完整信息" );
					return;
				}
				
				//加载所有控件的值
				$this->commentView->loadWidgets ( $this->params );
				//校验所有控件的值
				if (! $this->commentView->verifyWidgets ())
				{
					break;
				}
		
				$arrCommentBean = array(
								'class' => 'model' ,
								'orm' => array(
									'table' => 'comment_comment',
									'disableTableTrans' => true,
								) ,
							);
				$aCommentModel = BeanFactory::singleton()->createBean($arrCommentBean,'comment') ;
				
				$this->commentView->setModel($aCommentModel);
				$this->commentView->exchangeData ( DataExchanger::WIDGET_TO_MODEL );
				
				$aCommentModel->setData('pid',$this->params->get('pid'));
				$aCommentModel->setData('tid',$this->params->get('tid'));
				$aCommentModel->setData('type',$this->params->get('type'));
				$aCommentModel->setData('create_time',time());
		
				if ($aCommentModel->save ())
				{
					$this->commentView->hideForm ();
					$this->messageQueue ()->create ( Message::success, "保存成功" );
				}
				else
				{
					$this->messageQueue ()->create ( Message::error, "保存失败" );
					return;
				}
			} while ( 0 );
		}
	}
}
?>