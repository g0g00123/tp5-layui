<?php
namespace app\admin\model;
use think\Model;

class PostModel extends Model
{
	protected $table = 'think_post';

	//自动完成
	protected $auto = ['comment_status'];

	//修改器
	protected function setCommentStatusAttr($data)
    {
    	if(isset($data['comment_status'])){
    		return 'open';
    	}else{
    		return 'close';
    	}
    	
    }

    protected function comments()
    {
        return $this->hasMany('CommentModel','post_id');
    }
}