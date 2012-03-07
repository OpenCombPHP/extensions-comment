<?php
namespace org\opencomb\comment;

use org\jecat\framework\bean\BeanFactory;
use org\opencomb\platform\ext\Extension;
use org\jecat\framework\io\IOutputStream;
use org\jecat\framework\util\IHashTable;
use org\jecat\framework\ui\UI;
use org\jecat\framework\mvc\view\widget\Widget;

class AjaxComment extends Widget {
	public function __construct( $sId = '', $sTitle = null,  IView $aView = null) {
		//$sTid ,$sType ,$sPid = 0,$sText = '评论' , 
// 		if($sTid){
// 			$this->setTid($sTid);
// 		}
// 		if($sType){
// 			$this->setType($sType);
// 		}
// 		$this->setPid($sPid);
// 		$this->setText($sText);
		
		parent::__construct ( $sId, 'comment:AjaxComment.html',$sTitle, $aView );
	}
	
	public function display(UI $aUI,IHashTable $aVariables=null,IOutputStream $aDevice=null)
	{
		if($sTid = $this->attribute('tid')){
			$this->setTid($sTid);
		}
		if($sType = $this->attribute('type')){
			$this->setType($sType);
		}
		if($sPid = $this->attribute('pid')){
			$this->setPid($sPid);
		}
		if($sText = $this->attribute('text')){
			$this->setText($sText);
		}
		
		parent::display($aUI, $aVariables,$aDevice);
	}
	
	/**
	 * @return the $sTid
	 */
	public function tid() {
		return $this->sTid;
	}
	
	/**
	 * @return the $sType
	 */
	public function type() {
		return $this->sType;
	}
	
	/**
	 * @return the $sPid
	 */
	public function pid() {
		return $this->sPid;
	}
	
	/**
	 * @param field_type $sTid
	 */
	public function setTid($sTid) {
		$this->sTid = (string)$sTid;
	}
	
	/**
	 * @param field_type $sType
	 */
	public function setType($sType) {
		$this->sType = (string)$sType;
	}
	
	/**
	 * @param number $sPid
	 */
	public function setPid($sPid) {
		$this->sPid = (string)$sPid;
	}
	
	public function text() {
		return $this->sText;
	}
	public function setText($sText) {
		$this->sText = (string)$sText;
	}
	
	private $sTid;
	private $sType;
	private $sPid = 0;
	private $sText = '评论';
}
?>