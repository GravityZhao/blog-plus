<?php
Route::group('', function () {
    Route::get('/', 'home/Index/index');  //跳转至首页
    Route::get('/article/[:id]', 'home/Index/article');  //跳转至文章页
});

Route::group('admin', function () {
    Route::get('/', 'admin/Index/index');  //跳转至后台首页

    Route::rule('/login', 'admin/Login/index', 'get|post');  //登录
    Route::rule('/logout', 'admin/Login/logout','get|post');  //退出登录

    Route::get('/article_list', 'admin/Article/table');  //跳转至文章编辑页
    Route::rule('/article_add', 'admin/Article/add', 'get|post');  //文章添加
    Route::rule('/article_edit/[:id]', 'admin/Article/edit', 'get|post');  //文章编辑
    Route::rule('/article_del/:id', 'admin/Article/del','get|post');  //文章删除

    Route::get('/category_list', 'admin/Category/table');  //跳转标签编辑页
    Route::rule('/category_add', 'admin/Category/add', 'get|post');  //标签增加
    Route::rule('/category_edit/[:id]', 'admin/Category/edit', 'get|post');  //标签更改
    Route::rule('/category_del/:id', 'admin/Category/del','get|post');  //标签删除
});
