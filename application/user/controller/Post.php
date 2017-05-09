<?php
namespace app\user\controller;
use app\user\controller\Base;
use app\user\model\PostModel;
use think\Db;

class Post extends Base
{
	
	public function add(){
		$data = input('post.');
        $postModel = new PostModel;
		$postModel->data($data);
		if($postModel->save()){
			return json(['success' => true,'msg' => '发表成功！']);
		}
		else{
			return json(['success' => false,'msg' => '发表失败！']);
		}
	}

	public function del(){
		$id = input('param.id');
		$result = PostModel::where('id',$id)-> update(['status' => 1]);
		if($result){
			return json(['success' => 'true','msg' => '删除成功！']);
		}
		else{
			return json(['success' => 'fasle','msg' => '删除失败！']);
		}
	}

	public function getList($id='')
	{
		
		if(!empty($id)){
			$data = PostModel::get($id);
			$data->user;
			$data->comments;
			return json($data);
		}
		$data = Db::query("SELECT a.id,a.author,a.content,a.title,a.`status`,a.comment_status,a.comment_count,a.keep,a.`like`,a.feature_image,a.create_time,b.id authorId,b.nickname,b.avatar FROM think_post a LEFT JOIN think_user b ON a.author = b.id WHERE a. STATUS = 0 ORDER BY a.create_time DESC");
		return json($data);
	}


	public function edit(){
		$data = input('post.');
		$post = PostModel::get($data['id']);
	    if(!empty($data['like'])){
	    	$data['like'] = $post['like'] + $data['like'];
	    }	
	    if(!empty($data['keep'])){
			$data['keep'] = $post['keep'] + $data['keep'];
	    }
	    if(!empty($data['comment_count'])){
	    	$data['comment_count'] = $post['comment_count'] + $data['comment_count'];
	    }
		$postModel = new PostModel;
    	$result = $postModel->save($data,['id' => $data['id']]);
		if($result){
			return json(['success' => 'true','msg' => '修改成功！']);
		}
		else{
			return json(['success' => 'fasle','msg' => '修改失败！']);
		}
	}



	public function upload(){
		$file = request()->file('file');
		if($file){
			$info = $file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'uploads');
			$fileName = explode('.',$info->getFilename());
			$data = ['code' => 0,'msg' => '','data' => ['src' => request()->domain().'/uploads/'.$fileName[0].'.'.$info->getExtension()]];
			return json($data);
		}
	}
}