jquery(function(){
	//
	jquery('a.ajax_comment').on('click',function(){
		var commentList = jquery(this).parent('.ajax_comment_div').next('.ajax_comment_list');
		if( commentList.find('.commentList').length > 0 && commentList.is(":visible")){
			commentList.hide();
		}else if( commentList.find('.commentList').length > 0 && commentList.not(":visible")){
			commentList.show();
		}else{
			getComment(jquery(this));
		}
		return false;
	});
	//获得评论表单和已有评论列表
	function getComment(that){
		var comment_list_field = that.parent('.ajax_comment_div').next('.ajax_comment_list');
		jquery.ajax({
			url: that.attr('href')+'&rspn=noframe'
			, dataType:'html'
			, beforeSend:function(){
				comment_list_field.html('<div class="comment_loadding">加载中...</div>');
			}
			, success: function(html) {
				comment_list_field.html(html);
			}
		}) ;
	}
});