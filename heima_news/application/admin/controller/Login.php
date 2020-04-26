<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function index(){
        return view('');
    }

    public function login(){
        $username = input('username');
        $password = input('password');

        $login_key = 'user:'.$username;
        
        
        // 引用封装的助手函数
        $redis = getRedis();

        if(!$redis->exists($login_key)){
            return $this->error('登录失败：用户名不存在');
        }



        $login_val = $redis->get($login_key);
        if($login_val != $password){
            
            if(!$redis->exists($username.":serror")){
                //密码错误
                $redis->set($username.":serror",0,86400);
            }

            //错误次数+1
            $redis->incr($username.":serror");

            // 记录登录错误的次数
            $count = $redis->get($username.":serror");
            // 如果次数达到了3次
            if($count >= 3){
                return $this->error('该用户已锁定，10s后再试');
            }
            return $this->error('登录失败：用户名或密码错误');
        }

        $redis->del($username.":serror");
        session('admin:user',$username);
        return $this->success('登录成功',url('admin/news/index'));

    }
}
