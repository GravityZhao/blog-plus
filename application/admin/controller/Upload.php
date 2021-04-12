<?php


namespace app\admin\controller;

use think\Request;
use think\Controller;

class Upload extends Controller
{

    public function index(){
        $this->fetch();
        $this->navsManager();
        return view('upload');
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
            '文件管理'  =>[
                [
                    '上传文件' => url('#'),
                    '文件列表' => url('#'),
                ]
            ],
        ]);
    }

    public function upload()
    {
        $file = Request::file('upload_file');
        dump($file);
//        $upload = $file->move(ROOT_PATH."/public/upload_file/","$file_name");
//        if($upload){
//            echo("<script>alert(1)</script>");
//        }
    }

//    public function upload()
//    {
//
//        if($_FILES["file"]["error"])
//        {
//            echo $_FILES["file"]["error"];
//        }
//        else
//        {
//            //上传exe文件
//            if($_FILES["file"]["type"]=="application/octet-stream"&&$_FILES["file"]["size"]<102400000)
//            {
//
//                $file_exist = 0;
//                $file_md5 = md5_file($_FILES);
//                $filename = "static/upload_file/exe_file/".$_FILES["file"]["name"];
////                if(in_array($file_md5,Db::table('file')->field('file_hash')->select())
////                {
////                    echo "该文件已存在";
////            }
//            else if (file_exists($filename))
//            {
//                echo "该文件名已被占用";
//            }
//            else
//            {
//                move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
//            }
//            }
//            else
//            {
//                echo "文件类型不正确！";
//            }
//        }
//    }
}