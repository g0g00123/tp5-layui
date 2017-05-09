<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AdminModel as Admin;

class Base extends Controller
{
	// 初始化
    protected function _initialize()
    {
    	if(empty(session('username')) && (request()->url() !== '/admin')){
        	$this -> redirect('/admin');
        }

        //密码校验
		if(config('auth_password_check')){
			$this->auth_password_check();
		}

		//过期时间校验
		if(config('auth_expired_check')){
			$this->auth_expired_check();
	    }
    }
	
    /**
	 * [auth_password_check 动态密码校验]
	 * 应用场景：修改密码后，使其它地方登录的账号进行操作时使账号失效
	 * @return [type] [description]
	*/
	protected function auth_password_check(){
		$Admin = new Admin;
		$where_query = array(
                'username' => session('username'),
                'password' => session('password'),
                'status'   => 0
            );
		$admin = $Admin->where($where_query)->find();
        if (!$admin) {
        	//注销当前账号
        	session(null);

            $this->error('登录失效:用户密码已更改','/admin');
        }
	}

	/**
	 * [auth_expired_check 登录时间校验
	 * 应用场景：主要是在他人电脑上登陆后，忘了登出
	 * @return [type] [description]
	 */
	protected function auth_expired_check(){
		$Admin = new Admin;
		$where_query = array(
                'username' => session('username'),
                'password' => session('password'),
                'status'   => 0
            );
		$admin = $Admin->where($where_query)->find();
		$time = time() - session('time');
        if ($time > config('auth_expired_time')) { //登录超时
        	//注销当前账号
        	session(null);
            $this->error('账号已过期','/admin');
        }
	}


}
