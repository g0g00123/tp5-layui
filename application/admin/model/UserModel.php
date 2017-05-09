<?php
namespace app\admin\model;
use think\Model;

class UserModel extends Model
{
	protected $table = 'think_user';

	//类型转换
	// protected $type = [
 //        'status'    =>  'tinyint',
 //        'sex'     =>  'tinyint',
 //        'mobile'  =>  'int',
 //    ];
}