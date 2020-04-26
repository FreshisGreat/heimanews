<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    //判断用户是否登录
    public function _initialize(){
        if(!session('?admin:user')){
            return $this->error('请先登录',url('admin/login/index'));
            // return $this->redirect(url('admin/login/login'));
        }
    }
}
