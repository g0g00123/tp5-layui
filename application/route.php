<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::get([
    'admin/edit/:id'              =>        'admin/admin/edit',
    'admin/update_password/:id'   =>        'admin/admin/update_password',
    'role/get/:id'             =>        'admin/permission/get',
    ]);
return [
    '__pattern__' => [
        'name'  => '\w+',
        'year'  => '\d{4}',
        'month' => '\d{2}',
        'id'    => '\d+',
    ],
    'admin'                    =>        'admin/login/index',
    'admin/login'              =>        'admin/login/login',
    'admin/loginout'           =>        'admin/admin/loginout',
    'admin/add'                =>        'admin/admin/add',
    'admin/upload'             =>        'admin/admin/upload',
    'admin/add_action'         =>        'admin/admin/add_action',
    'admin/get_list'           =>        'admin/admin/get_list',
    'admin/del_all'            =>        ['admin/admin/del_all',['method' => 'post']],
    'admin/del'                =>        'admin/admin/del',
    'admin/edit_action'        =>        'admin/admin/edit_action',
    'admin/update_pass_action' =>        'admin/admin/update_pass_action',
    'admin/welcome'            =>        'admin/admin/welcome',
    'checkVerify'              =>        'admin/login/checkVerify',
    
    'admin/user/add'           =>        'admin/user/add',
    'admin/user/add_action'    =>        'admin/user/add_action',
    'admin/user/get_list'      =>        'admin/user/get_list',
    'admin/user/get_list_data' =>        'admin/user/get_list_data',
    'admin/user/get_count'     =>        'admin/user/get_count',
    'admin/user/get_count_action'     => 'admin/user/get_count_action',
    'admin/user/get_map'       =>        'admin/user/get_map',
    'admin/user/get_map_action'   =>     'admin/user/get_map_action',
    'admin/user/del'           =>        'admin/user/del',
    'admin/user/getList'       =>        'admin/user/getList',

    'user/add'                 =>        'user/user/add',
    'user/login'                 =>       'user/user/login',
    'user/edit'                =>        'user/user/edit',
    'user/get/:id'             =>        'user/user/get',
    'user/updatePass'          =>        'user/user/updatePass',
    'user/del/:id'             =>        'user/user/del',

    'user/post/add'            =>        'user/post/add',
    'user/post/del'            =>        'user/post/del',
    'user/post/getList/[:id]'  =>        'user/post/getList',
    'user/post/edit'           =>        'user/post/edit',

    'user/comment/add'         =>        'user/comment/add',
    'user/upload'              =>        'user/user/upload',

    'admin/post/add'           =>        'admin/post/add',
    'admin/post/upload'        =>        'admin/post/upload',
    'admin/post/add_action'    =>        'admin/post/add_action',

    'role'                     =>        'admin/permission/role',
    'role/add'                 =>        'admin/permission/add_role',
    'role/del'                 =>        'admin/permission/del_all',
    
    'role/edit'                =>        'admin/permission/edit',
    'role/get_list'            =>        'admin/permission/get_list',
    'permission'               =>        'admin/permission/index',
    'permission/edit_role'     =>        'admin/permission/edit_role',
];
