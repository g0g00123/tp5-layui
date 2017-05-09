<?php
namespace app\user\model;

use think\Model;

class UserModel extends Model
{
	//设置完整的数据表
	protected $table = 'think_user';

	
	//自动完成
	// protected $insert = [
	// 	'create_time',
	// 	'update_time',
	// ];

	// protected $update = ['update_time'];

	//属性修改器
	// protected function setCreateTimeAttr($value,$data)
	// {
	// 	return time();
	// }

	// protected function setUpdateTimeAttr($value,$data)
	// {
	// 	return time();
	// }

	// // create_time读取器设置时间格式
    // protected function getCreateTimeAttr($datetime)
    // {
    //     return date('Y-m-d H:i:s', $datetime);
    // }
    // // update_time读取器设置时间格式
    // protected function getUpdateTimeAttr($datetime)
    // {
    //     return date('Y-m-d H:i:s', $datetime);
    // }

}