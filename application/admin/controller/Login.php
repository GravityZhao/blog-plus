<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Login extends Controller
{
    public function index()  //主方法 判断未登录 使用post来进行传参给model/User来进行和数据库信息比对
    {
        $user = model('User');
        if ($user->isLogin())
        {
            $this->success('已经登陆', '/admin');
        }
        if (Request::isPost())
        {
            $ok = false;  //$ok用来判断try是否执行
            try
            {
                $user->login(
                    input('post.username'),
                    input('post.password')
                );
                $ok = true;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            if ($ok) {
                $this->success('登陆成功', '/admin');
            }
        }
        return view();
    }

    public function logout()  //调用model/User来进行退出登录操作
    {
        model('User')->logout();
        $this->success('退出成功', '/admin/login');
    }
}
