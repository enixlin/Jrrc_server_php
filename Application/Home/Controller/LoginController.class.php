<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 这是一个登录的管理类
 *
 * @author linzhenhuan
 *        
 */
class LoginController extends Controller {
	public function index() {
	}
	
	// 显示登录介面
	public function login_show() {
		$this->display ( 'login' );
	}
	
	// 处理登录
	// 成功登录则 返回1，失败则返回0
	public function login_handle($name, $password) {
		$model = M ( 'user' );
		$condition ['uname'] = $name;
		$condition ['password'] = $name;
		
		$result = $model->select ();
		foreach ( $result as $r ) {
			if ($r ['uname'] == $name && $r ['password'] == $password) {
				// 登录成功，写入session
				session ( "name", $name );
				session ( "id", $r ['id'] );
				return 1;
			}
		}
		return 0;
	}
	
	// 处理登出
	public function logout_handle($id) {
		// echo "logout page";
		if (session ( 'id' ) == $id) {
			session ( 'id', null );
			return 1;
		} else {
			// echo "logout page error";
			return 0;
		}
	}
	
	// android登录
	public function login_android(){
		$name=I($_POST['name']);
		$password=I($_POST['password']);
		if($this->login_handle($name, $password)){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(-1);
		}
	}
}