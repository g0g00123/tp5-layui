<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\RoleModel;
use app\admin\model\AdminModel;

class Permission extends Base
{
	
	public function index(){
		$list = AdminModel::where('status', 0)->order('create_time', 'desc')->paginate(10);
		$listArr = json_decode(json_encode($list),true);
		$data = $listArr['data'];
		for ($i=0; $i < sizeof($data); $i++) { 
			$admin = AdminModel::get($data[$i]['id']);
			if(!is_null($admin['role_id'])){
				$role = RoleModel::get($admin['role_id']);
			    $data[$i]['roleName'] = $role['name'];
			}else{
				$data[$i]['roleName'] = '-';
			}
		}
		$page = $list->render();
		$this->assign('list',$data);
		$this->assign('page',$page);
        return $this->fetch();
	}

    public function role(){
    	$list = RoleModel::where('status', 0)->order('create_time', 'desc')->paginate(10);
		$this->assign('list',$list);
        return $this->fetch();
    }

    public function get_list(){
    	$list = RoleModel::where('status', 0)->order('create_time', 'desc')->select();
        return json($list);
    }
    

    public function add_role()
    {
    	$data = input('post.');
        $role = RoleModel::where(['name' => $data['name'],'status' => 0])->find();
        if($role){
            return json(['success' => false,'msg' => '该角色名已存在！']);
        }
        $roleModel = new RoleModel;
		$roleModel->data($data);
		if($roleModel->save()){
			return json(['success' => true,'msg' => '添加成功！']);
		}
		else{
			return json(['success' => false,'msg' => '添加失败！']);
		}
    }

    public function del_all(){
    	$data = input('param.ids');
        $arr = explode(',',$data);
        $roleModel = new RoleModel;
    	$result = $roleModel->where('id','in',$arr)->update(['status' => 1]);
    	if($result){
    		return json(['success' => true,'msg' => '删除成功']);
    	}else{
    		return json(['success' => false,'msg' => '删除失败']);
    	}
    }



    public function edit(){
    	$roleModel = new RoleModel;
    	$data = input('post.');
    	$result = $roleModel->save($data,['id' => $data['id']]);
    	if($result){
    		return json(['success' => true,'msg' => '编辑成功,重新登陆才能生效']);
    	}else{
    		return json(['success' => false,'msg' => '编辑失败']);
    	}
    	
    }

    public function get($id){
    	$role = RoleModel::get($id);
    	return json($role);
    }

    public function edit_role(){
    	$data = input('post.');
    	$admin = AdminModel::get($data['id']);
    	$result = $admin->save($data);
    	if($result){
    		return json(['success' => true,'msg' => '设置成功,重新登陆才能生效']);
    	}else{
    		return json(['success' => false,'msg' => '设置失败']);
    	}
    }
}