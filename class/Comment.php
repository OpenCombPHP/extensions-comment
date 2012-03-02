<?php 
namespace org\opencomb\comment ;

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
		//评论功能
		WeaveManager::singleton()->registerTemplate( 'oc-wonei-bridge:UserState.html', "/div@1", 'comment:TopComment.html', Patch::insertAfter ) ;
// 		WeaveManager::singleton()->registerTemplate( 'oc-wonei-bridge:FrameView.html', "/div@1", 'comment:TopComment.html', Patch::insertAfter ) ;
	
	}
}