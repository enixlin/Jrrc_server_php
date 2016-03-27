<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 用户管理类
 *
 * @author linzhenhuan
 *        
 */
class UserController extends Controller {
	
	// 增加用户,成功返回1，失败返回0
	public function addUser($name, $password) {
		$model = M ( 'user' );
		$result = $model->select ();
		foreach ( $result as $r ) {
			if ($r ['uname'] == $name) {
				echo "name is exist";
				return 0;
			}
		}
		$condition ['uname'] = $name;
		$condition ['password'] = $password;
		$condition ['status'] = '1';
		$result = $model->add ( $condition );
		return 1;
	}
	
	// 修改用户信息，包括用户名、密码、用户状态
	// 成功 返回 1
	// 用户名已存在 返回 -1
	// 无此用户 返回 0
	public function modifyUser($id, $name, $password, $status) {
		$model = M ( 'user' );
		$condition ['id'] = $id;
		$result = $model->select ();
		foreach ( $result as $r ) {
			if ($r ['uname'] == $name) {
				// echo "存在相同的用户名";
				// 存在相同的用户名，返回-1
				return - 1;
			}
		}
		$result = $model->where ( $condition )->select ();
		// dump( $result);
		if ($result) {
			// 用户id存在，则写入
			$condition ['uname'] = $name;
			$condition ['password'] = $password;
			$condition ['status'] = $status;
			$result = $model->save ( $condition );
			
			return 1;
		} else {
			// 用户不存在
			return 0;
		}
	}
	
	// 删除用户，实际上软删除
	public function deleteUser($id) {
		$model = M ( 'user' );
		$condition ['id'] = $id;
		$result = $model->where ( $condition )->select ();
		//dump( $result);
		if ($result) {
			$condition ['status'] = '0';
			$result = $model->save ( $condition );
			return $result;
		} else {
			//echo "无此用户";
			return 0;
		}
	}
	
	
}