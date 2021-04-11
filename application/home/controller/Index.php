<?php

namespace app\home\controller;

use think\Controller;

class Index extends Controller        //用来将信息返回到页面上
{
    public function index()
    {
        $model = model('common/Article')->with('Category')->with('User')->order('create_time', 'desc');
        $c_id = input('get.c_id', 0);
        if ($c_id > 0)
        {
            $model->where('c_id', $c_id);
        }
        $articles = $model->paginate(10);
        $this->assign('title', 'Blog');
        $this->assign('articles', $articles);
        $this->assign('categorys', model('common/Category')->select());
        return view();
    }

    public function article($id)
    {
        $article = model('common/Article')->with('Category')->with('User')->find($id);
        $this->assign('title', base64_decode($article->title));
        $this->assign('article', $article);
        return view();
    }
}
