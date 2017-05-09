<?php
namespace app\user\model;
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
        //hasMany(hasOne)外键在子联对象中
        
        return $this->hasMany('CommentModel','post_id')->alias('a')->join('think_user b','a.from_user_id = b.id');
    }

    protected function user()
    {
        //belongsTo外键在父联对象中
        
        return $this->belongsTo('UserModel','author');
    }
}