<?php

namespace app\admin\controller;

// 文章类
class Article extends Common  //继承controller/Common
{
    protected function initialize()
    {
        parent::initialize();  //子类Artical有初始化方法且要继承父类Common的初始化方法，则使用parent::initialize();

        $this->setTabs();
    }

    private function setTabs(array $tabs = [])  //设置标签的路径
    {
        $this->assign('tabs', array_merge([
            '文章列表'  => url('/admin/article_list'),
            '添加文章'  => url('/admin/article_add'),
        ], $tabs));
    }

    private function setCategorys()  //查询数据库将文章分类传递给view
    {
        $this->assign('categorys', model('Category')->where('delete_time', null)->select());
    }

    // 文章列表
    public function table()  //此方法显示文章列表 返回view/artical/table
    {
        $this->setTitle('文章列表');

        $articles = model('Article')->with('User')->with('Category')->where('delete_time', null)->order(['id' => 'desc'])->paginate(10);
        if (empty($articles))
        {
            $this->assign('msg', '没有文章');
        }
        else
        {
            $this->assign('articles', $articles);
        }
        return view();
    }

    // 添加文章
    public function add()  //添加文章 调用model/Artical的add()方法添加文章 返回view/artical/add
    {
        if (request()->isPost())
        {
            $result = model('Article')->add(input('post.'));
            if (1 == $result)
            {
                $this->success('添加成功', '/admin/article_list');
            }
            $this->assign('msg', $result);
        }
        $this->setTitle('添加文章');
        $this->setCategorys();
        return view();
    }

    // 编辑保存文章
    public function edit($id=0)  //编辑文章 返回view/artical/edit
    {
        if (request()->isPost())
        {
            $result = model('Article')->edit($id, input('post.'));
            if (1 == $result)
            {
                $this->success('保存成功', '/admin/article_list');
            }
            $this->assign('msg', $result);
        }
        $article = model('Article')->with('ArticleContent')->find($id);
        if ($article)
        {
            $this->assign('article', $article);
        }
        else
        {
            $this->assign('msg', '不存在文章');
        }
        $this->setCategorys();
        $this->setTitle('编辑文章');
        $this->setTabs(['编辑文章' => 'javascript:void(0)']);
        return view();
    }

    // 删除文章
    public function del($id)  //删除文章
    {
        if (model('Article')->destroy($id)) $this->success('删除成功', '/admin/article_list');  //使用destroy来进行数据库记录的删除
        $this->error('删除失败', 'admin/article_list');
    }
}
