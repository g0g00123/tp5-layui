<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\UserModel;
use think\Db;

class User extends Base
{
	
	public function add(){
		return $this->fetch();
	}

	public function add_action(){
		$data = input('post.');
        $user = UserModel::where(['username' => $data['username'],'status' => 0])->find();
        if($user){
            return json(['success' => false,'msg' => '该用户名已存在！']);
        }

        $user2 = UserModel::where(['nickname' => $data['nickname'],'status' => 0 ])->find();
        if($user2){
        	return json(['success' => false,'msg' => '该昵称已存在！']);
        }
        $data['province'] = getLocation()['province'];
        $data['city'] = getLocation()['city'];
        $userModel = new UserModel;
		$data['password'] = md5($data['password']);
		$userModel->data($data);
		if($userModel->save()){
			return json(['success' => true,'msg' => '添加成功！']);
		}
		else{
			return json(['success' => false,'msg' => '添加失败！']);
		}
	}
	
	public function get_list(){
		$list = UserModel::where('status', 0)
			    ->order('create_time', 'desc')
			    ->paginate(10);
		$this->assign('list',$list);
		return $this->fetch('list');
	}

	public function getList(){
		$list = UserModel::where('status', 0)
			    ->order('create_time', 'desc')
			    ->select();
		return json($list);
	}


	public function get_count(){
		return $this->fetch();
	}

	public function get_count_action(){
		$user = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year`, DATE_FORMAT(create_time, '%m') as `month`,count(*) as count FROM think_user GROUP BY DATE_FORMAT(create_time, '%Y') , DATE_FORMAT(create_time, '%m')");
		$admin = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year`, DATE_FORMAT(create_time, '%m') as `month`,count(*) as count FROM think_admin GROUP BY DATE_FORMAT(create_time, '%Y') , DATE_FORMAT(create_time, '%m')");
		$post = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year`, DATE_FORMAT(create_time, '%m') as `month`,count(*) as count FROM think_post GROUP BY DATE_FORMAT(create_time, '%Y') , DATE_FORMAT(create_time, '%m')");
		
		$userYear = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year` FROM think_user GROUP BY DATE_FORMAT(create_time, '%Y') ");
		$adminYear = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year` FROM think_admin GROUP BY DATE_FORMAT(create_time, '%Y') ");
		$postYear = Db::query("SELECT DATE_FORMAT(create_time, '%Y') AS `year` FROM think_post GROUP BY DATE_FORMAT(create_time, '%Y') ");
		$yearArr = array_merge($userYear,$adminYear,$postYear);
		return json(['year'=>array_column(array_unique($yearArr,SORT_REGULAR),'year'),'admin'=>$admin,'user'=>$user,'post'=>$post]);
		
	}

	public function get_map(){
		return $this->fetch();
	}

	public function get_map_action(){
		$data = Db::query("SELECT COUNT(*) AS count,province FROM think_user WHERE
	DATE_FORMAT(create_time, '%Y') = DATE_FORMAT(NOW(), '%Y') GROUP BY province");
		return json($data);
	}


	public function get_list_data(){
		$list = UserModel::where('status', 0)
			    ->order('create_time', 'desc')
			    ->paginate(10);
		return json_encode($list);
	}

	public function del(){
		$id = input('post.id');
    	$userModel = new UserModel;
    	$result = $userModel->where('id',$id)->update(['status' => 1]);
    	if($result){
    		return json(['success' => true,'msg' => '删除成功']);
    	}else{
    		return json(['success' => false,'msg' => '删除失败']);
    	}
    }
}