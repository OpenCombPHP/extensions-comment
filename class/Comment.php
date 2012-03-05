<?php 
namespace org\opencomb\comment ;

use org\jecat\framework\bean\BeanFactory;

use org\jecat\framework\ui\xhtml\weave\Patch;
use org\jecat\framework\ui\xhtml\weave\WeaveManager;
use org\opencomb\platform\ext\Extension ;

class Comment extends Extension
{
	/**
	 * 载入扩展
	 */
	public function load()
	{
		BeanFactory::singleton()->registerBeanClass("org\\opencomb\\comment\\AjaxComment",'AjaxComment') ;
	}
}