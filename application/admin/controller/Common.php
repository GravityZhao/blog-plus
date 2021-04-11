<?php

namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{

    protected $user;

    protected function initialize()
    {
        $user = model('User');
        if (false == $user->isLogin()) {
            $this->error('请登录...', '/admin/login');  //未登录跳转至登录页面
        }
        $this->user = $user->getInfo();
        $this->navsManager();
    }

    protected function setTitle($title) {  //将文章标题返回到view
        $this->assign('title', $title);
        $this->assign('activeTab', $title);
    }

    private function navsManager()  //将导航栏信息返回到view
    {
        $this->assign('navs', [
            '文章管理'  => [
                [
                    '文章列表'  => url('/admin/article_list'),
                    '添加文章'  => url('/admin/article_add'),
                ],
            ],
            '分类管理'  => [
                [
                    '文章分类'  => url('/admin/category_list'),
                    '增加分类'  => url('/admin/category_add'),
                ],
            ],
        ]);
    }
}
