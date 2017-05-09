<?php
namespace app\user\controller;
use app\user\controller\Base;
use app\user\model\CommentModel;
use app\user\model\PostModel;

class Comment extends Base
{
	
	public function add(){
		$data = input('post.');
		$id = $data['post_id'];
		$post = PostModel::get($id);
		$post['comment_count'] = $post['comment_count'] + 1;
		$post->save();
        $commentModel = new CommentModel;
		$commentModel->data($data);
		if($commentModel->save()){
			return json(['success' => true,'msg' => '发表成功！']);
		}
		else{
			return json(['success' => false,'msg' => '发表失败！']);
		}
	}

	
}