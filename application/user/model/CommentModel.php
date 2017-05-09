<?php
namespace app\user\model;

use think\Model;

class CommentModel extends Model
{
	//设置完整的数据表
	protected $table = 'think_comment';

	protected function user()
    {
        //belongsTo外键在父联对象中
        return $this->belongsTo('UserModel','from_user_id');
    }
}