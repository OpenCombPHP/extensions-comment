<?php
namespace org\opencomb\comment;

use org\jecat\framework\auth\IdManager;

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
				'model'=>'comment',
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
			'model:comment'=>array(
				'class' => 'model' ,
				'orm' => array(
						'table' => 'comment:comment',
				) ,
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
				
				if(!$this->params->has('tid') || !$this->params->has('type') ){
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
		
				$this->commentView->exchangeData ( DataExchanger::WIDGET_TO_MODEL );
				
				$this->modelComment->setData('pid',0);
				if($this->params->has('pid')){
					$this->modelComment->setData('pid',$this->params->get('pid'));
				}
				$this->modelComment->setData('tid',$this->params->get('tid'));
				$this->modelComment->setData('uid',IdManager::singleton()->currentId()->userId());
				$this->modelComment->setData('type',$this->params->get('type'));
				$this->modelComment->setData('create_time',time());
				
				if ($this->modelComment->save ())
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
		}else{
			//登录?
			if(!IdManager::singleton()->currentId()){
				$this->commentView->variables()->set('bAllowSubmit',false) ;
			}else{
				$this->commentView->variables()->set('bAllowSubmit',true) ;
			}
		}
	}
}
?>